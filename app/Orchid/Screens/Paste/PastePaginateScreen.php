<?php

namespace App\Orchid\Screens\Paste;

use App\Models\Paste;
use App\Orchid\Layouts\Paste\PastePaginateLayout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class PastePaginateScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $pastes = Auth::user()
            ->pastes()
            ->where(function ($query) {
                $query->whereNull('expiration_time')
                    ->orWhere('expiration_time', '>=', Carbon::now());
            })
            ->orderBy('id', 'desc')
            ->defaultSort('created_at', 'desc')
            ->paginate(10);

        return [
            'pastePaginate'  => $pastes,
        ];
    }

    /**
     * Display header name.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Все пасты';
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::make(__('Create'))
                ->icon('plus')
                ->route('platform.pastes.create'),
            Link::make('Вернуться на сайт')
                ->route('pastes'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            PastePaginateLayout::class,
        ];
    }

    /**
     * @param Request $request
     * @return void
     */
    public function remove(Request $request): void
    {
        Paste::findOrFail($request->get('pasteHash'))->delete();
        Toast::info('Паста успешно удалена');
    }
}
