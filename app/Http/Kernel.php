<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

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
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Torann\Currency\Middleware\CurrencyMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \RealRashid\SweetAlert\ToSweetAlert::class,

        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
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

        'student.auth' => \App\Http\Middleware\RedirectIfNotStudent::class,
        'student.guest' => \App\Http\Middleware\RedirectIfStudent::class,
        // 'student.verified' => \App\Http\Middleware\EnsureStudentEmailIsVerified::class,
        // 'student.password.confirm' => \App\Http\Middleware\RequireStudentPassword::class,
        'edu_facility.auth' => \App\Http\Middleware\RedirectIfNotEduFacility::class,
        'edu_facility.guest' => \App\Http\Middleware\RedirectIfEduFacility::class,
        // 'edu_facility.verified' => \App\Http\Middleware\EnsureEduFacilityEmailIsVerified::class,
        // 'edu_facility.password.confirm' => \App\Http\Middleware\RequireEduFacilityPassword::class,
        'edu.auth' => \App\Http\Middleware\RedirectIfNotEdu::class,
        'edu.guest' => \App\Http\Middleware\RedirectIfEdu::class,
        // 'edu.verified' => \App\Http\Middleware\EnsureEduEmailIsVerified::class,
        // 'edu.password.confirm' => \App\Http\Middleware\RequireEduPassword::class,
        'admin.auth' => \App\Http\Middleware\RedirectIfNotAdmin::class,
        'admin.guest' => \App\Http\Middleware\RedirectIfAdmin::class,
        // 'admin.verified' => \App\Http\Middleware\EnsureAdminEmailIsVerified::class,
        // 'admin.password.confirm' => \App\Http\Middleware\RequireAdminPassword::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'StudentPhoneVerified' => \App\Http\Middleware\CheckStudentPhoneVerification::class,
        'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
        'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
    ];
}
