<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

use App\Models\Task;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Dashboard')
                ->icon('browser')
                ->route('platform.task')
                ->badge(function () {
                    return auth()->user()
                            ->tasks()
                            ->get()
                            ->filter(function ($task) {
                                return Task::STATUS_START === $task->status_job;
                            })
                            ->count();
                }),

            Menu::make('Company Settings')
                ->icon('building')
                ->route('platform.company_info'),

            Menu::make('Black List')
                ->icon('envelope')
                ->route('platform.black_list'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('System')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),

            Menu::make(__('Script'))
                ->icon('text-left')
                ->route('platform.systems.script')
                ->permission('platform.systems.script'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
            Menu::make('Relation Users')
                ->route('platform.profile.relations')
                ->icon('people'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users'))
                ->addPermission('platform.systems.script', __('Script')),
        ];
    }
}
