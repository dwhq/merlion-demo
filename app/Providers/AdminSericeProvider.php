<?php
namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Merlion\AdminProvider;
use Merlion\Components\Menu;

class AdminSericeProvider extends AdminProvider
{
    public function admin($admin): \Merlion\Components\Layouts\Admin
    {
        return $admin
            ->id('admin')
            ->default()
            ->guard('web')
            ->authenticatedRoutes(function () {
                Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
                Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
                Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
            })
            ->menus([
                Menu::make()
                    ->label('Users')
                    ->link('/admin/users')
                    ->icon('ti ti-users'),
                Menu::make()
                    ->label('Roles')
                    ->link('/admin/roles')
                    ->icon('ti ti-user-check'),
                Menu::make()
                    ->label('Permissions')
                    ->link('/admin/permissions')
                    ->icon('ti ti-lock'),
            ])
            ->path('admin');
    }
}