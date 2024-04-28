<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachCategoriesToSpecialistRequest;
use App\Models\Category;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }
    /**
     * Show the form for attaching categories to the specialist
     */
    public function specialistCategoriesForm(Request $request): Response
    {
        return Inertia::render("Specialist/ChooseCategories", ['categories' => Category::all()]);
    }

    /**
     * Attach categories to specialist
     */
    public function attachCategoriesToSpecialist(AttachCategoriesToSpecialistRequest $request,Specialist $specialist)
    {
        $user = $request->user();
        if ($user->can('update', $specialist)) {
            foreach ($request->categories as $category_id) {
                $category = Category::findOrFail($category_id);
                $request->user()->specialist->categories()->attach($category);
            }
            return to_route('dashboard')->with('message', ['text' => 'Uzupełniono dane specjalisty. Poczekaj na weryfikację profilu.', 'status' => 'success']);
        } else {
            return redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
