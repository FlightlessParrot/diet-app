<?php

namespace App\Orchid\Layouts\Specialist;

use App\Models\Province;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class EditSpecialistAddressLayout extends Rows
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
        return [Input::make('address.line_1')->type('text')->title('Adres - pierwsza linia'),
        Input::make('address.line_2')->type('text')->title('Adres - druga linia'),
        Select::make('address.province_id')
        ->fromModel(Province::class, 'name'),
        Input::make('address.city')->type('text')->title('Miejscowość'),
        Input::make('address.code')->type('text')->title('Kod Pocztowy'),
            ];
    }
}
