<?php

namespace LSV\ForceHttps;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * @author  Lucas Vasconcelos <lucas@vscn.co>
 * @package  LSV\ForceHttps
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Registra novo user provider para a aplicação.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->isLocal()) {
            url()->forceSchema("https");
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Overrides the service redirect by our modified version.
        $this->app['redirect'] = $this->app->share(function ($app) {
            $redirector = new Redirector($app['url']);

            // If the session is set on the application instance, we'll inject it into
            // the redirector instance. This allows the redirect responses to allow
            // for the quite convenient "with" methods that flash to the session.
            if (isset($app['session.store'])) {
                $redirector->setSession($app['session.store']);
            }

            return $redirector;
        });
    }
}