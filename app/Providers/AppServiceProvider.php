<?php

namespace App\Providers;

use App\Services\DeviceService\DeviceServiceAbstract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            DeviceServiceAbstract::class,
            'App\Services\DeviceService\\' . config('custom.device.type') . 'DeviceService'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
