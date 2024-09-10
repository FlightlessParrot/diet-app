<?php

namespace App\Orchid\Layouts\Specialist;

use App\Models\Specialist;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SpecialistListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'specialists';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [TD::make('id'),TD::make('title')->sort()->filter(Input::make()),
        TD::make('name')->sort()->filter(Input::make()),
        TD::make('surname')->sort()->filter(Input::make()), 
        TD::make('user_id')->sort(),
        TD::make('active')->sort(),
        TD::make(__('Actions'))
        ->align(TD::ALIGN_CENTER)
        ->width('100px')
        ->render(fn (Specialist $specialist) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([

                Link::make(__('Edit'))
                    ->route('platform.specialist.edit', $specialist->id)
                    ->icon('bs.pencil'),

                Button::make(__('Delete'))
                    ->icon('bs.trash3')
                    ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                    ->method('remove', [
                        'id' => $specialist->id,
                    ]),
            ])),];
    }
}
