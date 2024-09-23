<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Orchid\Layouts\Category\CategoryListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CategoryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return ['categories'=>Category::all()];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Kategorie';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action->width('100px')[]
     */
    public function commandBar(): iterable
    {
        return [Link::make("Dodaj")->route('platform.category.new')];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [CategoryListLayout::class];
    }

    public function delete(Request $request) : void {
        $category=Category::find($request->category);
        $category->delete();
        Toast::success('Usunięto kategorię.');
    }
}
