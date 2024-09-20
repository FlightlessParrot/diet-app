<?php

namespace App\Orchid\Screens\Discount;

use App\Models\Discount;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DiscountScreen extends Screen
{

    public $discount;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Discount $discount): iterable
    {
        return ['discount' => $discount];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Kod ' . $this->discount->code;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Usuń')->method('deleteModel')->confirm('Czy na pewno chcesz usunąć kod?')];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [Layout::legend(
            'discount',
            [

                Sight::make('code', 'kod'),
                Sight::make('amount', 'zniżka w %'),
                Sight::make('limited', 'liczba użyć')->render(fn(Discount $discount) => $discount->limited ? 'ograniczona' : 'nieograniczona'),
                Sight::make('quantity', 'ile użyć pozotało'),
            ]
        )];
    }

    public function deleteModel()
    {
        $this->discount->delete();
        Toast::success('Kod został usunięty.');
        return to_route('platform.discounts');
    }
}
