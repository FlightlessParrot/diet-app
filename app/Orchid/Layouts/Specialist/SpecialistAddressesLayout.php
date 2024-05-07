<?php

namespace App\Orchid\Layouts\Specialist;

use App\Models\Address;
use App\Models\Province;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SpecialistAddressesLayout extends Table
{
    protected $title='Adresy';
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'addresses';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
         
        TD::make('line_1','adres'),
        TD::make('line_2',''),
        TD::make('province_id','Województwo')->render(fn ($address) => Province::find($address->province_id)->name),
        TD::make('city','miasto'),
        TD::make('code','kod pocztowy'),
            ];
    }
}
