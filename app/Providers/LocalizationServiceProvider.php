<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    private $languages = [
        'ru',
        'de',
        'fr',
        'es',
        'it',
        'jp',
        'kr',
        'pl',
        'cz',
        'se',
        'no',
    ];

    private $exceptions = [
        'api',
        'robots.txt',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $current = $default = App::currentLocale();

        if (Cookie::has('lang')) {
            if (in_array(Cookie::get('lang'), $this->languages)) {
                App::setLocale(Cookie::get('lang'));
                $current = Cookie::get('lang');
            }
        } else {
            $location = substr(Request::server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

            if (in_array($location, Config::get('app.languages'))) {
                App::setLocale($location);
                $current = $location;
            }

            setcookie('lang', $current, strtotime('+1 year'), '/');
        }

        if (in_array(Request::segment(1), Config::get('app.languages'))) {
            $current = Request::segment(1);
            App::setLocale($current);
            setcookie('lang', $current, strtotime('+1 year'), '/');
        }

        if (Request::segment(1) && !in_array(Request::segment(1), $this->languages) && !in_array(Request::segment(1), $this->exceptions)) {
            $current = $default;
            App::setLocale($current);
            setcookie('lang', $current, strtotime('+1 year'), '/');
        }

        $route = $current !== $default ? $current : '';
        Config::set('lang', $route);
    }
}
