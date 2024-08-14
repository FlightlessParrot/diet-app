<?php

namespace App\Orchid\Layouts\Specialist;

use App\Enums\Specialization;
use App\Models\MyRole;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;
use App\Enums\Title;
use App\Models\Target;

class EditSpecialistLayout extends Rows
{
    /**
     * Array of availlable tiltes.
     * 
     * @var array $title
     */
    protected $titles;

    /**
     * Array of availlable specializations.
     * 
     * @var array $specializations
     */
    protected $specializations;

    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title='Podstawowe dane';


    public function __construct( Title $title=Title::LIC, Specialization $specialization = Specialization::DK )
    {
        $this->titles=[];
        foreach($title::cases() as $titleCase)
        {
            $this->titles[$titleCase->value]=$titleCase->value;
        }
        foreach($specialization::cases() as $case)
        {
            $this->specializations[$case->value]=$case->value;
        }

    }
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Select::make('specialist.title')->options($this->titles)->title('Tytuł')->empty('Brak'),
            Select::make('specialist.specialization')->options($this->specializations)->title('Specjalizacja')->empty('Brak'),
            Input::make('specialist.name')->type('text')->title('Imię')->required(),
            Input::make('specialist.surname')->type('text')->title('Nazwisko')->required(),
            Input::make('specialist.phone.number')->type('text')->mask([
                'mask' => '999 999 999',])->title('Imię')->required(),
                Relation::make('targets.')
            ->fromModel(Target::class, 'name')
            ->multiple()
            ->title('Grupy docelowe'),
            Button::make(__('update specialist'))
            ->type(Color::BASIC())
            ->icon('bs.check-circle')
            ->method('update_specialist')
    ];
    }

    
}
