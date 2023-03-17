<?php

namespace App\Orchid\Screens;

use App\Enums\Access;
use App\Enums\ExpirationTime;
use App\Http\Requests\CreatePasteRequest;
use App\Service\PasteService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;

class PasteScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        $userPastes = Auth::user()
            ->pastes()
            ->whereNull('expiration_time')
            ->orWhere(function ($query) {
                $query->where('expiration_time', '>=', Carbon::now());
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $table = [];
        $num = 1;
        foreach ($userPastes as $userPaste) {
            $table[] = (new Repository(
                [
                    'num' => $num,
                    'paste' => $userPaste->paste,
                    'locale' => $userPaste->locale,
                    'access' => $userPaste->access,
                    'expiration_time' => (string) $userPaste->expiration_time,
                    'created_at' => $userPaste->created_at,
                ]
            ));
            $num++;
        }

        return [
            'table'  => $table,
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
            Layout::rows([
                Input::make('paste')
                    ->required()
                    ->type('text')
                    ->title('Паста'),
                Input::make('locale')
                    ->type('text')
                    ->title('Язык'),
                Select::make('access')
                    ->options(array_combine(Access::getValues(), Access::getValues()))
                    ->title('Доступность')
                    ->help('Выберете значение'),
                Select::make('expirationTime')
                    ->options(array_combine(ExpirationTime::getValues(), ExpirationTime::getValues()))
                    ->title('Срок действия')
                    ->help('Выберете значение'),
                Button::make('Отправить')
                    ->method('buttonClickProcessing')
                    ->type(Color::PRIMARY())
                    ->method('create'),
//                Button::make('Отправить')
//                    ->method('buttonClickProcessing')
//                    ->type(Color::DANGER())
//                    ->method('delete'),
            ]),


            Layout::table('table', [
                TD::make('num', '№'),
                TD::make('paste', 'Паста')
                    ->render(function (Repository $model) {
                        return Str::limit($model->get('paste'), 200);
                    }),
                TD::make('locale', 'Язык')
                    ->render(function (Repository $model) {
                        return Str::limit($model->get('locale'), 200);
                    }),
                TD::make('access', 'Доступность')
                    ->render(function (Repository $model) {
                        return Str::limit($model->get('access'), 200);
                    }),
                TD::make('expiration_time', 'Срок действия')
                    ->render(function (Repository $model) {
                        $expirationTime = $model->get('expiration_time');
                        return $expirationTime ? Str::limit($expirationTime, 200) : 'Неограниченно';
                    }),
                TD::make('created_at', 'Дата создания'),
            ]),
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
            'hash' => Str::random(),
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

        return redirect()->back();
    }
}
