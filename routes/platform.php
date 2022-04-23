<?php

declare(strict_types=1);

use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\User\UserProfileRelationsScreen;
use App\Orchid\Screens\Task\TaskListScreen;
use App\Orchid\Screens\Task\TaskOrdersListScreen;
use App\Orchid\Screens\Task\TaskEditScreen;
use App\Orchid\Screens\CompanySettings;
use App\Orchid\Screens\EmailBlackList;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Tasks list
Route::screen('tasks', TaskListScreen::class)
    ->name('platform.task')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->push(__('Dashboard'), route('platform.task'));
    });

// Platform > Tasks list
Route::screen('tasks/{task}/orders', TaskOrdersListScreen::class)
    ->name('platform.task.orders')
    ->breadcrumbs(function (Trail $trail, $task) {
        return $trail
            ->parent('platform.task')
            ->push(__('Orders'), route('platform.task.orders', $task));
    });

// Platform > Tasks > Edit
Route::screen('tasks/{task}/edit', TaskEditScreen::class)
    ->name('platform.task.edit')
    ->breadcrumbs(function (Trail $trail, $task) {
        return $trail
            ->parent('platform.task')
            ->push(__('Edit Task'), route('platform.task.edit', $task));
    });

// Platform > Tasks > Create
Route::screen('tasks/new', TaskEditScreen::class)
    ->name('platform.task.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.task')
            ->push(__('Create Task'), route('platform.task.create'));
    });

// Platform > Company Settings
Route::screen('company_info', CompanySettings::class)
    ->name('platform.company_info');

// Platform > Black List
Route::screen('black_list', EmailBlackList::class)
    ->name('platform.black_list');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > Profile > Relation Users
Route::screen('profile/relations', UserProfileRelationsScreen::class)
->name('platform.profile.relations')
->breadcrumbs(function (Trail $trail) {
    return $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile.relations'));
});

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });
