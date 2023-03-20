<?php

namespace App\Orchid\Layouts\Paste;

use App\Models\Paste;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PastePaginateLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'pastePaginate';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', '№'),
            TD::make('paste_hash', 'Ссылка')
                ->render(function (Paste $paste) {
                    return Link::make($paste->paste_hash)
                        ->route('platform.paste.detail', $paste->paste_hash);
                }),
            TD::make('paste', 'Паста')
                ->render(function (Paste $paste) {
                    return Str::limit($paste->paste, 200);
                }),
            TD::make('locale', 'Язык')
                ->render(function (Paste $paste) {
                    return Str::limit($paste->lang, 200);
                }),
            TD::make('access', 'Доступность')
                ->render(function (Paste $paste) {
                    return Str::limit($paste->access, 200);
                }),
            TD::make('expiration_time', 'Срок действия')
                ->render(function (Paste $paste) {
                    $expirationTime = $paste->expiration_time;
                    return $expirationTime ?: 'Неограниченно';
                }),
            TD::make('created_at', 'Дата создания')
                ->render(function (Paste $paste) {
                    return $paste->created_at;
                }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Paste $paste) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->method('remove', [
                                    'pasteHash' => $paste->paste_hash,
                                ]),
                        ]);
                }),
        ];
    }
}
