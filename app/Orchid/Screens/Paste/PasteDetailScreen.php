<?php

namespace App\Orchid\Screens\Paste;

use App\Models\Paste;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\TextArea;
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
                TextArea::make('paste')
                    ->title('Паста')
                    ->placeholder($this->paste->paste)
                    ->value($this->paste->paste),
                TextArea::make('paste')
                    ->title('Паста')
                    ->placeholder(route('pastes.detail', $this->paste->paste_hash))
                    ->value(route('pastes.detail', $this->paste->paste_hash)),
            ])
        ];
    }
}
