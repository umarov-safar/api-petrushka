<?php

namespace App\Providers;

use DB;
use Log;
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
        \Bouncer::useRoleModel(\App\Models\Role::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // https://stackoverflow.com/a/57519919/12562591
        /*
        DB::listen(function($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                //$query->time
            );
        });
        */

    }
}
