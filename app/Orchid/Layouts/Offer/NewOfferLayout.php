<?php

namespace App\Orchid\Layouts\Offer;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;
class NewOfferLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [Input::make('name')->title('Tytuł oferty.')->required(),
        Quill::make('description')->title('Opis oferty')->required(),
        Input::make('price')
        ->title('Cena')
        ->type('number')
        ->step(0.01)
        ->mask('222 222 222,22')
        ->help('W polskich złotych.')
        ->required(),
        Input::make('duration')->help('Tylko liczby naturalne.')->title('Czas trwania w miesiącach')->type('number')->required()->min(1),
    
        CheckBox::make('discount')
        ->sendTrueOrFalse()
        ->placeholder('Promocja')
        ->help('Zaznacz, jeśli jest to oferta promocyjna'),
Input::make('old_price')
->title('Stara cena')
->type('number')
->step(0.01)
->mask('222 222 222,22')
->help('Poprzednia cena w polskich złotych. Jeśli nie masz ustawionej promocji to pole nie ma znaczenia.')
->value(0)

,];
    }
}
