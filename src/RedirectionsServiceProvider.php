<?php

namespace PavelZanek\RedirectionsLaravel;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use PavelZanek\RedirectionsLaravel\Console\Commands\PruneTableRedirectsCommand;
use PavelZanek\RedirectionsLaravel\Http\Middleware\RedirectsMiddleware;
use PavelZanek\RedirectionsLaravel\Providers\EventServiceProvider;

class RedirectionsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__ . '/../config/redirections.php' => config_path('redirections.php'),
        ], 'redirections-config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/redirections.php', 'redirections-config'
        );

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'redirections-migrations');

        $this->registerRoutes();

        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'redirections-translations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'redirections-views');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PruneTableRedirectsCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/../lang/' => resource_path('lang/vendor/redirections-translations'),
            ], 'redirections-translations');

            $this->publishes([
                __DIR__.'/../resources/views/redirects/' => resource_path('views/vendor/redirections-views/redirects'),
                __DIR__.'/../resources/views/layouts/' => resource_path('views/vendor/redirections-views/layouts'),
            ], 'redirections-views');
        }

        $kernel->pushMiddleware(RedirectsMiddleware::class);
    }


    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('redirections.route_prefix'),
            'middleware' => config('redirections.route_middleware'),
        ];
    }
}