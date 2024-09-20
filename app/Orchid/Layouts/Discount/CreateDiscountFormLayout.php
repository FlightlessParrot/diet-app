<?php

namespace App\Orchid\Layouts\Discount;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\CheckBox;

class CreateDiscountFormLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title='Utwórz kod rabatowy.';

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('code')->title('Kod')->type('text')->required(),
            Input::make('amount')->title('Zniżka w %')->type('number')->required(),
            CheckBox::make('limited')
                ->sendTrueOrFalse()
                ->placeholder('Ograniczona liczba użyć.')
                ->help('Zaznacz, jeśli kod mam mieć ograniczoną liczbę użyć.'),
            Input::make('quantity')->title('Liczba użyć')->type('quantity')
            ->help('Jeśli kod ma nieograniczoną liczbę użyć pozostaw pole puste'),
            Button::make('Utwórz')->method('store'),
        ];
    }
}
