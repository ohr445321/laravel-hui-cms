<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*********** 注册模型 ************/
        $this->app->bind('UsersModel', 'App\Model\Users');
        $this->app->bind('PermissionsModel', 'App\Model\Permissions');
        $this->app->bind('RoleModel', 'App\Model\Role');
    }
}
