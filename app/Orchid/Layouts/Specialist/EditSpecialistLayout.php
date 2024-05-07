<?php

namespace App\Orchid\Layouts\Specialist;

use App\Models\MyRole;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;
class EditSpecialistLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title='Podstawowe dane';

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('specialist.title')->type('text')->title('Tytuł'),
            Input::make('specialist.name')->type('text')->title('Imię')->required(),
            Input::make('specialist.surname')->type('text')->title('Nazwisko')->required(),
            Button::make(__('update specialist'))
            ->type(Color::BASIC())
            ->icon('bs.check-circle')
            ->method('update_specialist')
    ];
    }
}
