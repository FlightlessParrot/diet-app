<?php

namespace App\Orchid\Screens\Offer;

use App\Models\Offer;
use App\Orchid\Layouts\Offer\EditOfferLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class EditOfferScreen extends Screen
{

    public $offer;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Offer $offer): iterable
    {
        return ['offer'=>$offer];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Edytuj ofertę: "'.strval($this->offer->name).'"';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Edytuj')->method('edit'),Button::make('Usuń')->icon('bs.trash')->method('remove')];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [EditOfferLayout::class];
    }

    public function edit(Request $request)
    {
        $request->validate([
            'name'=>'string|required|max:255',
            'description'=>'string|required|max:65400',
            'price'=>'numeric|required|min:1',
            'duration'=>'numeric|required|min:1'
        ]);
        $offer=$this->offer;
        $offer->name=$request->name;
        $offer->description=$request->description;
        $offer->price=$request->price;
        $offer->duration=$request->duration;
        $offer->save();
        Toast::success('Edytowano ofertę.');
        
    }

     public function remove()
    {
        
        $offer=$this->offer;
        
        $offer->delete();
        Toast::info('Usunięto ofertę.');
        return redirect()->route('platform.offers');
    }
}
