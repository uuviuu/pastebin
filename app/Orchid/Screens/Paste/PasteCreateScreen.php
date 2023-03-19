<?php

namespace App\Orchid\Screens\Paste;

use App\Http\Requests\CreatePasteRequest;
use App\Orchid\Layouts\Paste\PasteCreateLayout;
use App\Orchid\Layouts\Paste\PasteListLayout;
use App\Service\PasteService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class PasteCreateScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'pasteList'  => PasteService::lastPastes(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создайте пасту';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
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
        return [
            PasteCreateLayout::class,
            PasteListLayout::class,
        ];
    }

    /**
     * @param CreatePasteRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function create(CreatePasteRequest $request): RedirectResponse
    {
        $data = [
            'created_by_id' => Auth::user()['id'],
            'paste' => $request->get('paste'),
            'locale_lang' => $request->get('locale'),
            'paste_hash' => Str::random(),
            'access' => $request->get('access'),
        ];

        if ($request->has('expirationTime')) {
            $expirationTime = $request->get('expirationTime');
        }

        $paste = PasteService::create($data, $expirationTime ?? null);

        if ($paste) {
            Alert::success('Паста успешно создана');
        } else {
            Alert::error('Ошибка! Повторите попытку.');
        }

        return redirect()->route('platform.paste.detail', $paste);
    }
}
