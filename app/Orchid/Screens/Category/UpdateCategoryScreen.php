<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UpdateCategoryScreen extends Screen
{
    public $category;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Category $category): iterable
    {
        return ['category'=>$category];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Edytuj kategorię';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Usuń')->icon('bs.trash')->confirm('Czy na pewno chcesz usunąć kategorię?')->method('delete',['category'=>$this->category->id])];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [Layout::rows([
            Input::make('name')->value($this->category->name)->title('Nazwa')->required(),
            Button::make('Aktualizuj')->method('update')

        ])];
    }

    public function update(Request $request)
    {
        $request->validate(['name'=>'string|max:255|required|unique:categories,name']);
        $category= $this->category;
        $category->name = $request->name;
        $category->save();
        Toast::success('Zaktualizowano kategorię');

    }

    public function delete(Request $request) : RedirectResponse {
        $category=Category::find($request->category);
        $category->delete();
        Toast::success('Usunięto kategorię.');
        return to_route('platform.categories');
    }
}
