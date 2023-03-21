<?php

namespace App\Orchid\Layouts\Paste;

use App\Enums\Access;
use App\Enums\ExpirationTime;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class PasteCreateLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            TextArea::make('paste')
                ->required()
                ->rows(8)
                ->title('Паста'),
            Select::make('lang')
                ->options(array_combine(['PHP','C','C++','C#','Python','JS'], ['PHP','C','C++','C#','Python','JS']))
                ->title('Язык')
                ->help('Выберете значение'),
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
        ];
    }
}
