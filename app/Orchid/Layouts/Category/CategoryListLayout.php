<?php

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

use function Termwind\render;

class CategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [TD::make('id'),TD::make('name','nazwa'),TD::make('action','akcje')->render(fn(Category $category)=>DropDown::make()->align(TD::ALIGN_CENTER)
        ->icon('bs.three-dots-vertical')
        ->list([
            Link::make('Edytuj')->icon('bs.arrow-up-circle')->route('platform.category.edit',[$category->id]),
            Button::make('Usuń')->icon('bs.trash')->confirm('Czy na pewno chcesz usunąć kategorię?')->method('delete',['category'=>$category->id])
        ])),
        ];
    }
}
