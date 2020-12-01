<?php

namespace App\Providers;

use App\Entities\Exports;
use App\Entities\Imports;
use App\JsonApi\JsonApiBuilder;
use App\Observers\ExportsObserver;
use App\Observers\ImportsObserver;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
     * @return void
     */
    public function boot()
    {
        Exports::observe( ExportsObserver::class);
        Imports::observe( ImportsObserver::class);
    }
}
