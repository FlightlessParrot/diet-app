<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIconRequest;
use App\Models\Icon;
use App\Models\Specialist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class IconController extends Controller
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
        
        return Inertia::render('Specialist/CreateImages',[ 'avatarUrl'=>Auth::user()->specialist->attachment()->first()?->url(), 'iconUrl'=>Auth::user()->specialist->icon?->url,
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIconRequest $request, Specialist $specialist): RedirectResponse
    {
        if ($request->user()->can('update', $specialist)) {
            
            if ($specialist->icon !== null) {
                Storage::delete($specialist->icon->path);
                $specialist->icon->delete();
            }

            $path = $request->file('icon')->store('public/specialist/icons');
            $url = Storage::url($path);
            $specialist->icon()->create(['path' => $path, 'url' => $url]);
            return  redirect()->back()->with('message', ['text' => 'Zmieniono ikonę.', 'status' => 'success']);
        } else {
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Icon $icon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Icon $icon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Icon $icon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Icon $icon) : RedirectResponse
    {
        $specialist = $icon->specialist;
        if (Auth::user()->specialist->id === $specialist->id) {
            Storage::delete($icon->path);
            $icon->delete();
            return  redirect()->back()->with('message', ['text' => 'Usunięto ikonę.', 'status' => 'success']);
        } else {
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
}
