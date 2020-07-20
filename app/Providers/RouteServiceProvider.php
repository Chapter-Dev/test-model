<?php 
namespace App\Providers;

use mmghv\LumenRouteBinding\RouteBindingServiceProvider as BaseServiceProvider;

class RouteServiceProvider extends BaseServiceProvider
{
    /**
     * Boot the service provider
     */
    public function boot()
    {
        // The binder instance
        $binder = $this->binder;
        $binder->implicitBind('App');

        // Here we define our bindings
    }
}