<?php

namespace App\Orchid\Screens\Specialist;

use App\Models\Category;
use App\Models\Specialist;
use App\Orchid\Layouts\Specialist\EditSpecialistLayout;
use App\Orchid\Layouts\Specialist\SpecialistAddressesLayout;
use App\Orchid\Layouts\Specialist\SpecialistServicesLayout;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;

use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EditSpecialistScreen extends Screen
{
    /**
     * @var Specialist;
     */
    public $specialist;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Specialist $specialist): iterable
    {
        $categories=$specialist->categories()->get();
        $services=$specialist->serviceKinds()->get();
        $serviceCities=$specialist->serviceCities()->get();
        $addresses=$specialist->addresses()->get();
        return ['specialist'=>$specialist, 'addresses'=>$addresses, 'services'=>$services, 'serviceCities'=>$serviceCities, "categories"=>$categories];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Edytuj specjalistę.';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Aktywuj')->icon('bs.plus-circle')->method('activate')->canSee(!$this->specialist->active),
        Button::make('Dezaktywuj')->icon('bs.trash3')->method('disactive')->canSee($this->specialist->active),];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('specialist', [
                Sight::make('name','Imię'),
                Sight::make('surname','Nazwisko'),
                Sight::make('active','Aktywny'),
            ]),


            EditSpecialistLayout::class, SpecialistAddressesLayout::class, SpecialistServicesLayout::class];
    }

    public function update_specialist(Request $request): void
    {
        $this->specialist->name=$request->specialist['name'];
        $this->specialist->surname=$request->specialist['surname'];
        $this->specialist->title=$request->specialist['title'];
        $this->specialist->save();

        
        Toast::info('Specjalista został zaktualizowany.');
    }

    public function update_categories(Request $request): void
    {
        $this->specialist->categories()->detach();
        if(is_array($request->categories))
        {
        foreach($request->categories as $category_id)
        {
            $this->specialist->categories()->attach($category_id);
        }
        }

        
        Toast::info('Kategorie specjalisty zostały zaktualizowane.');
    }

    public function activate(Request $request): void
    {
        $this->specialist->active=true;
        $this->specialist->save();

        Toast::success('Aktywowano specjalistę.');
    }
    public function disactivate(Request $request): void
    {
        $this->specialist->active=false;
        $this->specialist->save();

        Toast::success('Aktywowano specjalistę.');
    }
}
