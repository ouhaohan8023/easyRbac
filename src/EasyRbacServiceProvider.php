<?php
/*
 * Copyright (c) 2024. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace Ouhaohan8023\EasyRbac;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Ouhaohan8023\EasyRbac\Command\MenuPersist;
use Ouhaohan8023\EasyRbac\Command\MenuRecover;
use Ouhaohan8023\EasyRbac\Command\SyncPermission;
use Ouhaohan8023\EasyRbac\Facade\EasyRbac as EasyRbacFacade;
use Ouhaohan8023\EasyRbac\Middleware\EasyAuth;
use Ouhaohan8023\EasyRbac\Model\EasyRbac;

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
        $this->app['router']->aliasMiddleware('easy-rbac', EasyAuth::class);
        // give all right to super admin
        Gate::before(function ($user, $ability) {
            return $user->hasRole(config('easy-rbac.super_admin_key')) ? true : null;
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                MenuPersist::class,
                MenuRecover::class,
                SyncPermission::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/easy-rbac.php', 'easy-rbac');

        $this->app->singleton('EasyRbac', function () {
            return new EasyRbac();
        });
        $this->app->alias('EasyRbac', EasyRbacFacade::class);
    }
}
