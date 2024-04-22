<?php
/*
 * Copyright (c) 2024. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace Ouhaohan8023\EasyRbac;

use Illuminate\Support\ServiceProvider;

class EasyRbacServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes(
            [
                __DIR__.'/Database/migrations' => database_path('migrations'),
                __DIR__.'/Config/easy-rbac.php' => config_path('easy-rbac.php'),
                __DIR__.'/Config/permission.php' => config_path('permission.php'),
            ],
            'config'
        );
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/easy-rbac.php', 'easy-rbac');

        $this->app->singleton('EasyRbac', function () {
            return new EasyRbac;
        });
    }
}
