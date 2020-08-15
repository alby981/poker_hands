<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PokerHelperServiceProvider extends ServiceProvider {

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        require_once app_path() . '/Helpers/PokerHelper.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        //
    }

}
