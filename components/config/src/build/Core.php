<?php

namespace zeni18\config\build;

/**
 * Class Core.
 */
class Core
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var array
     */
    protected $env = [];

    /**
     * @param $name
     * @param $value
     *
     * @return bool
     */
    public function set($name, $value)
    {
        $arr = explode('.', $name);

        $items = &$this->items;

        foreach ($arr as $key) {
            if (!isset($items[$key])) {
                $items[$key] = [];
            }

            $items = &$items[$key];
        }
        $items = $value;

        return true;
    }

    /**
     * @param $name
     * @param null $default
     *
     * @return null|array|mixed
     */
    public function get($name, $default = null)
    {
        $arr = explode('.', $name);

        $tmp = $this->items;
        foreach ($arr as $key) {
            if (isset($tmp[$key])) {
                $tmp = $tmp[$key];
            } else {
                return $default;
            }
        }

        return $tmp;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        $arr = explode(',', $name);

        $items = $this->items;
        foreach ($arr as  $key) {
            if (!isset($items[$key])) {
                return false;
            }

            $items = $items[$key];
        }

        return true;
    }

    /**
     * @param $dir
     */
    public function loadFiles($dir)
    {
        foreach (glob($dir.'/*') as $f) {
            $info = pathinfo($f);
            $this->set($info['filename'], include $f);
        }
    }

    /**
     * @param string $file
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function env($file = '.env')
    {
        if (is_file($file)) {
            try {
                $env = parse_ini_file($file, false);
            } catch (\Exception $e) {
                throw  new \Exception(sprintf('reslove file %s fail.', $file));
            }

            foreach ($env as $key => $value) {
                $this->env[strtoupper($key)] = $value;
            }

            return $this;
        }

        throw  new \Exception(sprintf('reslove file %s fail.', $file));
    }

    /**
     * @param $name
     *
     * @return null|mixed
     */
    public function getEnv($name)
    {
        $name = strtoupper($name);
        if (isset($this->env[$name])) {
            return $this->env[$name];
        }

        return null;
    }

    /**
     * @param $items
     *
     * @return mixed
     */
    public function setItems($items)
    {
        return $this->items = $items;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}
