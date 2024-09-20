<?php

namespace App\Orchid\Layouts\Discount;

use App\Models\Discount;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DiscountListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'discounts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [TD::make('code','kod'),
                TD::make('amount','zniżka w %'),
                TD::make('limited', 'liczba użyć')->render(fn(Discount $discount)=>$discount->limited ? 'ograniczona' : 'nieograniczona'),
                TD::make('quantity','ile użyć pozotało'),
                TD::make('action','akcje')->render(fn(Discount $discount)=>Link::make('Szczegóły')->route('platform.discount',[$discount->id])),
            ];
    }
}
