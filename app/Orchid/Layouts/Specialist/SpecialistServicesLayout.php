<?php

namespace App\Orchid\Layouts\Specialist;

use App\Models\Category;
use App\Models\ServiceCity;
use App\Models\ServiceKind;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class SpecialistServicesLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title='Usługi';

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [Select::make('services.')
        ->fromModel(ServiceKind::class, 'name')
        ->multiple()
        ->disabled()
        ->title('Rodzaj świadczonych usług'),
        Select::make('serviceCities.')
        ->fromModel(ServiceCity::class, 'name')
        ->multiple()
        ->disabled()
        ->title('Miasta'),
        Select::make('categories.')
        ->fromModel(Category::class, 'name')
        ->multiple()
        ->title('Kategorie'),
        Button::make('Zapisz')->type(Color::BASIC())
        ->icon('bs.check-circle')
        ->method('update_categories')
   
        ];

    }
}
