<?php

namespace App\Orchid\Screens\Paste;

use App\Models\Paste;
use App\Service\PasteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class PasteDetailScreen extends Screen
{
    protected $paste;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Paste $paste): array
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
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::make('Посмотреть на сайте')
                ->icon('eye')
                ->route('pastes.detail', $this->paste->paste_hash),
            ModalToggle::make('Пожаловаться')
                ->icon('pencil')
                ->modal('complaintModal')
                ->method('complaint'),
            Link::make('Вернуться на сайт')
                ->route('pastes'),
            Link::make(__('Create'))
                ->icon('plus')
                ->route('platform.pastes.create'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        PasteService::checkDetail($this->paste, Auth::user()['id'] ?? null);

        return [
            Layout::rows([
                TextArea::make('paste')
                    ->title('Паста')
                    ->rows(8)
                    ->placeholder($this->paste->paste)
                    ->value($this->paste->paste),
                Input::make('lang')
                    ->title('Язык')
                    ->placeholder($this->paste->lang)
                    ->value($this->paste->lang),
                TextArea::make('link')
                    ->title('Ссылка на пасту')
                    ->placeholder(route('pastes.detail', $this->paste->paste_hash))
                    ->value(route('pastes.detail', $this->paste->paste_hash)),
            ]),
            Layout::modal('complaintModal', Layout::rows([
                Input::make('complaint')
                    ->title('Напишите жалобу')
                    ->required(),
                Input::make('pasteHash')
                    ->value($this->paste->paste_hash)
                    ->hidden(),
            ]))->title('Напишите жалобу'),
        ];
    }

    /**
     * @param Request $request
     * @return void
     */
    public function complaint(Request $request): void
    {
        PasteService::complaint($request->get('pasteHash'), $request->get('complaint'));

        Toast::info('Жалоба успешно отправлена');
    }
}
