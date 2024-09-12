<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSocialMediaRequest;
use App\Http\Requests\UpdateSocialMediaRequest;
use App\Models\SocialMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SocialMediaController extends Controller
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
     * Store a newly created resource in storage.
     */
    public function store(StoreSocialMediaRequest $request) : RedirectResponse
    {

        $specialist=$request->user()->specialist;
        if($specialist->socialMedias()->where('type', $request->type)->first())
        {
            return  redirect()->back()->with('message', ['text' => 'Link do profilu tego typu juz istnieje.', 'status' => 'error']);
        }
        $socialMedia = $specialist->socialMedias()->create($request->all());
        return  redirect()->back()->with('message', ['text' => 'Utworzono link.', 'status' => 'success']);
    }
    /**
     * Display the specified resource.
     */
    public function show(SocialMedia $socialMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialMedia $socialMedia)
    {
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocialMediaRequest $request, SocialMedia $socialMedia):RedirectResponse
    {
        $specialist=Auth::user()->specialist;
        if($specialist->id!==$socialMedia->specialist->id)
        {
            return  redirect()->back()->with('message', ['text' => 'Wystapil blad.', 'status' => 'error']);
        }
        $socialMedia->update($request->all());
        return  redirect()->back()->with('message', ['text' => 'Zmieniono link.', 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialMedia $socialMedia)   : RedirectResponse
    {
        $specialist=Auth::user()->specialist;
        if($specialist->id!==$socialMedia->specialist->id)
        {
            return  redirect()->back()->with('message', ['text' => 'Wystapil blad.', 'status' => 'error']);
        }
        $socialMedia->delete();
        return  redirect()->back()->with('message', ['text' => 'Zmieniono link.', 'status' => 'success']);
    }
}
