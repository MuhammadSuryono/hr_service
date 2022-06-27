<?php

namespace App\Providers;

use App\Interfaces\AuthInterface;
use App\Interfaces\Cuti\CutiDispensasiInterface;
use App\Interfaces\Cuti\CutiInterface;
use App\Interfaces\Cuti\ReportingCutiInterface;
use App\Interfaces\FilerInterface;
use App\Interfaces\UserInterface;
use App\Repositories\AuthRepository;
use App\Repositories\Cuti\CutiDispensasi;
use App\Repositories\Cuti\CutiRepository;
use App\Repositories\Cuti\StatisticCutiRepository;
use App\Repositories\DivisionRepository;
use App\Interfaces\Division;
use App\Repositories\FilerRepository;
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

        $this->app->bind(
            Division::class, DivisionRepository::class
        );

        $this->app->bind(
            CutiInterface::class, CutiRepository::class
        );

        $this->app->bind(
            FilerInterface::class, FilerRepository::class
        );

        $this->app->bind(
            CutiDispensasiInterface::class, CutiDispensasi::class
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
