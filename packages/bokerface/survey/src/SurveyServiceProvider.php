<?php

namespace Bokerface\Survey;

use App\Http\Middleware\Admin;
use Bokerface\Survey\Middleware\Auth;
use Bokerface\Survey\Middleware\ExcludeAdmin;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class SurveyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */


    public function register()
    {
        $this->app->make('Bokerface\Survey\SurveyController');
        $this->loadViewsFrom(__DIR__ . '/views', 'survey');
        $this->loadViewsFrom(__DIR__ . '/views', 'components');

        app('router')->aliasMiddleware('auth', Auth::class);
        app('router')->aliasMiddleware('admin', Admin::class);
        app('router')->aliasMiddleware('exclude_admin', ExcludeAdmin::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        include __DIR__ . '/routes.php';
    }
}
