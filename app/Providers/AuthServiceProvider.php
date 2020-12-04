<?php

namespace App\Providers;

use App\Entities\Product;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected array $policies = [
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        /*Gate::guessPolicyNamesUsing(function ($model){
            return 'App\\Policies\\'.$model.'Policy';
        });*/
    }
}
