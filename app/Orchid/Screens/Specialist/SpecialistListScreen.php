<?php

namespace App\Orchid\Screens\Specialist;

use App\Models\Specialist;
use App\Orchid\Layouts\Specialist\SpecialistListLayout;
use Illuminate\Http\Request;

use Orchid\Support\Facades\Toast;


use Orchid\Screen\Screen;

class SpecialistListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return ['specialists'=>Specialist::paginate()];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Specjaliści';
    }

    public function description(): string|null
    {
        return 'Lista specjalistów';
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
        return [SpecialistListLayout::class];
    }
    public function remove(Request $request): void
    {
        $specialist=Specialist::findOrFail($request->get('id'));
        $specialist->cleanAndDelete();
        
        Toast::info(__('Specialist has been removed'));
    }
    
}
