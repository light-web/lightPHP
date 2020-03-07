<?php

namespace light\Http;

use zeni18\system\HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Luka\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Luka\Http\Middleware\AcceptLanguage::class,
        \Luka\Http\Middleware\StopAccessLowVersion::class,
        \Luka\Http\Middleware\TrustProxies::class,
    ];

    /** d
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Luka\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Luka\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Luka\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        'luka.jwt.auth' => \Luka\Http\Middleware\Jwt\Authenticate::class,
        'luka.jwt.refresh' => \Luka\Http\Middleware\Jwt\RefreshToken::class,
        'luka.send_captcha' => \Luka\Http\Middleware\SendCaptcha::class,
        'luka.verify_sso' => \Luka\Http\Middleware\VerifySSO::class,
        //后期废掉
        'luka.convert_jsonapi_to_general' => \Luka\Http\Middleware\ConvertJsonApiToGeneral::class,
        'luka.transformer' => \Luka\Http\Middleware\Transformer::class,
        //暂时stop
        'luka.scope' => \Luka\Http\Middleware\Scope::class,
    ];
}
