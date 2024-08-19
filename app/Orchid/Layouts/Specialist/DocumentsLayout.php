<?php

namespace App\Orchid\Layouts\Specialist;

use App\Models\Document;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;

class DocumentsLayout extends Table
{
    protected $title='Dokumenty';
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'documents';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [TD::make('name', 'Dokument'),TD::make(__('Actions'))
        ->align(TD::ALIGN_CENTER)
        ->width('100px')
        ->render(fn (Document $document) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([

                Link::make('Pobierz')
                    ->route('admin.document.download', [$document->id])
                    ->icon('bs.download'),

                Button::make(__('Delete'))
                    ->icon('bs.trash3')
                    ->confirm('Czy na pewno chcesz usunąć dokument? Ten proces jest nieodwracalny.')
                    ->method('removeDocument', [
                        'id' => $document->id,
                    ]),
                ])),];
     
    }
}
