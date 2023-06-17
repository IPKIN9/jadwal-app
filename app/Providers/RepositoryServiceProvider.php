<?php

namespace App\Providers;

use App\Interfaces\DetailJadwalInterface;
use App\Interfaces\GuruInterface;
use App\Interfaces\JadwalInterface;
use App\Interfaces\JurusanInterface;
use App\Interfaces\KelasInterface;
use App\Interfaces\MapelInterface;
use App\Interfaces\PangkatInterface;
use App\Interfaces\UserManageInterface;
use App\Repositories\DetailJadwalRepository;
use App\Repositories\GuruRepository;
use App\Repositories\JadwalRepository;
use App\Repositories\JurusanRepository;
use App\Repositories\KelasRepository;
use App\Repositories\MapelRepository;
use App\Repositories\PangkatRepository;
use App\Repositories\UserManageRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(JurusanInterface::class, JurusanRepository::class);
        $this->app->bind(PangkatInterface::class, PangkatRepository::class);
        $this->app->bind(KelasInterface::class, KelasRepository::class);
        $this->app->bind(MapelInterface::class, MapelRepository::class);
        $this->app->bind(GuruInterface::class, GuruRepository::class);
        $this->app->bind(JadwalInterface::class, JadwalRepository::class);
        $this->app->bind(DetailJadwalInterface::class, DetailJadwalRepository::class);
        $this->app->bind(UserManageInterface::class, UserManageRepository::class);
    }
}
