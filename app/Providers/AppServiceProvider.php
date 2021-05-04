<?php

namespace App\Providers;

use App\Http\Resources\API\BalanceAddMoneyResource;
use App\Http\Resources\API\BalanceGetResource;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        BalanceGetResource::withoutWrapping();
        BalanceAddMoneyResource::withoutWrapping();
    }
}
