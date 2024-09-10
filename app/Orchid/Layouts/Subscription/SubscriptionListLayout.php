<?php

namespace App\Orchid\Layouts\Subscription;

use App\Models\Subscription;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SubscriptionListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'subscriptions';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [TD::make('id'),
        TD::make('start_date','początek'),
        TD::make('end_date','koniec'),
        TD::make('','konto specialisty')->render(function (Subscription $subscription){
            $specialist=$subscription->payment->specialist;
            return Link::make($specialist->title.' '.$specialist->name.' '.$specialist->surname)
            ->route('platform.specialist.edit',[$subscription->id]);
            }
            )
        
        ];
    }
}
