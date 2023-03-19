<?php

namespace App\Orchid\Screens\Paste;

use App\Models\Paste;
use App\Orchid\Layouts\Paste\PasteWithComplaintLayout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class PasteWithComplaintScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        $pastes = Paste::whereNotNull('complaint_message')
            ->where(function ($query) {
                $query->whereNull('expiration_time')
                    ->orWhere('expiration_time', '>=', Carbon::now());
            })
            ->orderBy('id', 'desc')
            ->defaultSort('created_at', 'desc')
            ->paginate(10);

        return [
            'pasteWithComplaint'  => $pastes,
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
            PasteWithComplaintLayout::class,
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
