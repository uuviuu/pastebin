<?php

namespace App\Orchid\Screens\Paste;

use App\Models\Paste;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class PasteDetailScreen extends Screen
{
    protected $paste;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Paste $paste): iterable
    {
        $this->paste = $paste;

        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Паста №' . $this->paste->id;
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create'))
                ->icon('plus')
                ->route('platform.pastes.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('paste')
                    ->type('text')
                    ->readonly()
                    ->title('Паста')
                    ->placeholder($this->paste->paste),
            ])
        ];
    }
}
