<?php

namespace App\Providers;

use App\Entities\Exports;
use App\Entities\Imports;
use App\Observers\ExportsObserver;
use App\Observers\ImportsObserver;
use CloudCreativity\LaravelJsonApi\LaravelJsonApi;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PlacetoPay::class, static function () {
            return new PlacetoPay([
                'login' => config('placetopay.auth.login'),
                'tranKey' => config('placetopay.auth.tranKey'),
                'url' => config('placetopay.auth.url')
            ]);
        });
    }

    /**
     *
     */
    public function boot()
    {
        Exports::observe( ExportsObserver::class);
        ::observe( ImportsObserver::class);
        LaravelJsonApi::defaultApi('v1');
    }
}
