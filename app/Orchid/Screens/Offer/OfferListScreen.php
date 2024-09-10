<?php

namespace App\Orchid\Screens\Offer;

use App\Models\Offer;
use App\Orchid\Layouts\Offer\OfferListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class OfferListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return ['offers'=>Offer::all()];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Oferty';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make(__('Add'))->icon('bs.save')->route('platform.offer.new')];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [OfferListLayout::class];
    }
    public function remove(Request $request)
    {
        
        $offer=Offer::findOrFail($request->offerId);
        
        $offer->delete();
        Toast::info('Usunięto ofertę.');
        return redirect()->route('platform.offers');
    }
}
