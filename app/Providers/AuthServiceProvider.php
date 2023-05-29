<?php

namespace App\Providers;

use App\Models\User;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {

        LumenPassport::routes($this->app);
        LumenPassport::routes($this->app, ['prefix' => 'v1/oauth']);
    }
}
