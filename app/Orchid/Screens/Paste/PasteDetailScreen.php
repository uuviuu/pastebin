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
            ModalToggle::make('Пожаловаться')
                ->icon('pencil')
                ->modal('complaintModal')
                ->method('complaint'),
            Link::make('Вернуться на сайт')
                ->route('pastes'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        PasteService::checkDetail($this->paste, Auth::user()['id'] ?? null);

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
            ]),
            Layout::modal('complaintModal', Layout::rows([
                Input::make('complaint')
                    ->title('Напишите жалобу')
                    ->required(),
                Input::make('hash')
                    ->value($this->paste->paste_hash)
                    ->hidden(),
            ]))->title('Напишите жалобу'),
        ];
    }

    /**
     * @param Request $request
     */
    public function complaint(Request $request): void
    {
        $paste = Paste::findOrFail($request->get('hash'));
        $paste->complaint_message = $request->get('complaint');
        $paste->save();

        Toast::info('Жалоба успешно отправлена');
    }
}
