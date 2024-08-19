<?php

namespace App\Orchid\Screens\Specialist;

use App\Events\SpecialistActivated;
use App\Models\Category;
use App\Models\Document;
use App\Models\Specialist;
use App\Orchid\Layouts\Specialist\DocumentsLayout;
use App\Orchid\Layouts\Specialist\EditSpecialistLayout;
use App\Orchid\Layouts\Specialist\SpecialistAddressesLayout;
use App\Orchid\Layouts\Specialist\SpecialistServicesLayout;
use Hamcrest\Arrays\IsArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public $statistic;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Specialist $specialist): iterable
    {
        $statistic = $specialist->statistic;
        $categories=$specialist->categories()->get();
        $services=$specialist->serviceKinds()->get();
        $serviceCities=$specialist->serviceCities()->get();
        $addresses=$specialist->addresses()->get();
        $targets=$specialist->targets()->get();

        $data=['specialist'=>$specialist, 
        'addresses'=>$addresses, 
        'services'=>$services, 'serviceCities'=>$serviceCities, 
        "categories"=>$categories,'targets'=>$targets,'documents'=>$specialist->documents()->get()];
        isset($statistic) ? $data['statistic']=$statistic : $data['statistic']=null;
        return $data;
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
        Button::make('Dezaktywuj')->icon('bs.trash3')->method('disactivate')->canSee($this->specialist->active),];
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
            Layout::legend('statistic', [
                Sight::make('view_counter','Profil zobaczono'),
                Sight::make('review_grade','Ocena o specjaliście'),
               
                
            ])->canSee($this->statistic!==null),

            EditSpecialistLayout::class, SpecialistAddressesLayout::class, SpecialistServicesLayout::class, DocumentsLayout::class];
    }

    public function update_specialist(Request $request): void
    {
        $this->specialist->name=$request->specialist['name'];
        $this->specialist->surname=$request->specialist['surname'];
        $this->specialist->title=$request->specialist['title'];
        $this->specialist->specialization=$request->specialist['specialization'];
        $this->specialist->save();

        $phone=$this->specialist->phone;
        $phone->number=$request->specialist['phone']['number'];
        $phone->save();

        $this->specialist->targets()->detach();
        $this->specialist->targets()->attach($request->targets);

        
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
        SpecialistActivated::dispatch($this->specialist);
        Toast::success('Aktywowano specjalistę.');
    }
    public function disactivate(Request $request): void
    {
        $this->specialist->active=false;
        $this->specialist->save();

        Toast::success('Dezaktywowano specjalistę.');
    }

    public function removeDocument(Request $request)
    {
        $document=Document::findOrFail($request->id);
        if(Storage::disk('protected')->delete($document->path))
        {
         $document->delete();
         Toast::success('Usunięto dokument.');
        }
        Toast::error('Wystąþił błąd.');
    }
}
