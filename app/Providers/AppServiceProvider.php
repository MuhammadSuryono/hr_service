<?php

namespace App\Providers;

use App\Interfaces\AuthInterface;
use App\Interfaces\Cuti\ReportingCutiInterface;
use App\Interfaces\UserInterface;
use App\Repositories\AuthRepository;
use App\Repositories\Cuti\StatisticCutiRepository;
use App\Repositories\UserRepository;
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
        $this->app->bind(
            AuthInterface::class, AuthRepository::class
        );

        $this->app->bind(
            ReportingCutiInterface::class, StatisticCutiRepository::class
        );

        $this->app->bind(
            UserInterface::class, UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
