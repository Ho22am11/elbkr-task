<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (request()->has('locale')) {
        session(['locale' => request('locale')]);
        app()->setLocale(request('locale'));
    } elseif (session()->has('locale')) {
        app()->setLocale(session('locale'));
    }
    }
}
