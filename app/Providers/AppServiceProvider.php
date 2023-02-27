<?php

namespace App\Providers;

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
        view()->composer('layouts.admin', function ($view) {
            $user = auth()->user();
            $companyName = '';
            if ($user && $user->company) {
                $companyName = $user->company->name;
            }
            $view->with('companyName', $companyName);
        });
    }
}
