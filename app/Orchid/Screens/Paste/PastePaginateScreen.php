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
    public function query(): iterable
    {
        $pastes = Auth::user()
            ->pastes()
            ->whereNull('expiration_time')
            ->orWhere(function ($query) {
                $query->where('expiration_time', '>=', Carbon::now());
            })
            ->defaultSort('created_at', 'desc')
            ->paginate(10);

        return [
            'pastePaginate'  => $pastes,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Все пасты';
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
            PastePaginateLayout::class,
        ];
    }

    /**
     * @param Request $request
     */
    public function remove(Request $request)
    {
        Paste::findOrFail($request->get('paste_hash'))->delete();
        Toast::info('Паста успешно удалена');
    }
}