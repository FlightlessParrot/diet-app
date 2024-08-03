<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LanguageController extends Controller
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
        return Inertia::render('Specialist/SetLanguages', ['languages'=>Auth::user()->specialist->languages()->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguageRequest $request)
    {
        if ($request->user()->can('create', Language::class)) {
            $language = new Language();
            $language->name=$request->name;
            $request->user()->specialist->languages()->save($language);

            return  redirect()->back()->with('message', ['text' => 'Dodano język.', 'status' => 'success']);
        } else {
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LanguageRequest $request, Language $language)
    {
        if ($request->user()->can('update', $language)) {

            $language->name=$request->name;
            $language->save();

            return  redirect()->back()->with('message', ['text' => 'Edytowano język.', 'status' => 'success']);
        } else {
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        if (Auth::user()->can('delete', $language)) {

            $language->delete();

            return  redirect()->back()->with('message', ['text' => 'Usunięto język.', 'status' => 'success']);
        } else {
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
}
