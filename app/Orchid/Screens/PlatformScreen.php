<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            Layout::rows([
                Input::make('paste')
                    ->title('Paste')
                    ->required()
            ])
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Pastebin';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return '';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('GitHub')
                ->href('https://github.com/uuviuu/pastebin')
                ->icon('social-github'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [];
    }
}
