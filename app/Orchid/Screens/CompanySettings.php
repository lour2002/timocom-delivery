<?php

namespace App\Orchid\Screens;

use App\Models\CompanySettings as SettingsModel;
use Illuminate\Http\Request;

use App\Orchid\Layouts\CompanySettingsEditLayout;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;


class CompanySettings extends Screen
{
    public $company_settings;
    /**
     * Query data.
     * @param Request $request
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        return [
            'company_settings' => $request->user()->company_info,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->company_settings ? __('Edit - Company Settings') : __('Fill - Company Settings');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(CompanySettingsEditLayout::class)
                ->title(__('Company Information'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY())
                        ->icon('check')
                        ->method('save')
                ),
        ];
    }

    /**
     * @param Request $request
     */
    public function save(Request $request): void
    {
        $settings = $request->user()->company_info;

        $data = $request->get('company_settings');

        if(!$settings) {
            $data['user_id'] = $request->user()->id;
            $settings = new SettingsModel;
        }

        $settings
            ->fill($data)
            ->save();

        Toast::success(__('Company settings saved.'));
    }
}
