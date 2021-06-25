<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Meme;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    protected $policies =
    [
        Meme::class => MemePolicy::class
    ];
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

    }
}
