<?php

namespace App\Orchid\Screens\Discount;

use App\Models\Discount;
use App\Orchid\Layouts\Discount\CreateDiscountFormLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CreateDiscountScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Utwórz kod rabatowy.';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [CreateDiscountFormLayout::class];
    }

    public function store(Request $request)
    {
        Discount::create($request->all());
        Toast::success('Utworzono kod rabatowy.');
    }
}
