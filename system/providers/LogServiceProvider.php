<?php

/**
 * Class LogServiceProvider.
 */
class LogServiceProvider extends \zeni18\container\build\ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'log',
            function () {
                return $this->createLogger();
            }
        );
    }

    /**
     * @return \zeni18\log\build\Writer
     */
    public function createLogger()
    {
        $log = new \zeni18\log\build\Writer(
            new \Monolog\Logger(
                $this->channel()
            )
        );
        if ($this->app->hasMonologConfigurator()) {
            call_user_func($this->app->getMonologConfigurator(), $log->getMonolog());
        } else {
            $this->configureHandler($log);
        }

        return $log;
    }

    /**
     * @return string
     */
    public function channel()
    {
        return $this->app->config->get('app.env') ?? 'unknow';
    }

    /**
     * @param \zeni18\log\build\Writer $log
     */
    protected function configureHandler(zeni18\log\build\Writer $log)
    {
        $this->{'configure'.ucfirst($this->handler()).'Handler'}($log);
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param \Illuminate\Log\Writer $log
     */
    protected function configureSingleHandler(zeni18\log\build\Writer $log)
    {
        $log->useFiles(
            $this->app->storagePath().'/logs/light.log',
            $this->logLevel()
        );
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param \Illuminate\Log\Writer $log
     */
    protected function configureDailyHandler(zeni18\log\build\Writer $log)
    {
        $log->useDailyFiles(
            $this->app->storagePath().'/logs/light.log',
            $this->maxFiles(),
            $this->logLevel()
        );
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param \Illuminate\Log\Writer $log
     */
    protected function configureSyslogHandler(zeni18\log\build\Writer $log)
    {
        $log->useSyslog('light', $this->logLevel());
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param \Illuminate\Log\Writer $log
     */
    protected function configureErrorlogHandler(zeni18\log\build\Writer $log)
    {
        $log->useErrorLog($this->logLevel());
    }

    /**
     * Get the default log handler.
     *
     * @return string
     */
    protected function handler()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log', 'single');
        }

        return 'single';
    }

    /**
     * Get the log level for the application.
     *
     * @return string
     */
    protected function logLevel()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log_level', 'debug');
        }

        return 'debug';
    }

    /**
     * Get the maximum number of log files for the application.
     *
     * @return int
     */
    protected function maxFiles()
    {
        if ($this->app->bound('config')) {
            return $this->app->make('config')->get('app.log_max_files', 5);
        }

        return 0;
    }
}
