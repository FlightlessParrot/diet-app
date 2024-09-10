<?php

namespace App\Orchid\Screens\Offer;

use App\Models\Offer;
use App\Orchid\Layouts\Offer\EditOfferLayout;
use App\Orchid\Layouts\Offer\NewOfferLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class NewOfferScreen extends Screen
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
        return 'Nowa oferta';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Utwórz')->method('store')];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [NewOfferLayout::class];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'string|required|max:255',
            'description'=>'string|required|max:65400',
            'price'=>'numeric|required|min:1',
            'duration'=>'numeric|required|min:1'
        ]);
        $offer=new Offer();
        $offer->name=$request->name;
        $offer->description=$request->description;
        $offer->price=$request->price;
        $offer->duration=$request->duration;
        $offer->save();
        Toast::success('Utworzono ofertę.');
        return back();
    }
        
}
