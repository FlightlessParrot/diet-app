<?php

namespace App\Orchid\Layouts\Offer;

use App\Models\Offer;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\Currency;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OfferListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'offers';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id'),
            TD::make('name','Tytuł'),
            TD::make('duration','Czas trwania [mies.]'),
            TD::make('price','Cena')
            ->usingComponent(Currency::class, decimals: 2, decimal_separator: ',', thousands_separator: ' ', after: ' zł'),
            TD::make('old_price','Stara cena')
            ->usingComponent(Currency::class, decimals: 2, decimal_separator: ',', thousands_separator: ' ', after: ' zł'),
            TD::make('discount','Promocja')->render(fn(Offer $offer)=>$offer->discount ? 'Tak' : 'Nie'),
            TD::make(__('Actions'))->render(fn(Offer $offer)=>
                DropDown::make()->icon('bs.three-dots-vertical')
                    ->list([ Button::make('Delete')->method('remove',['offerId'=>$offer->id]),
                        Link::make('Edit')->route('platform.offer.edit',[$offer->id])
                    ])
        ),

        ];
    }
}
