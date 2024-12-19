<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDescriptionRequest;
use App\Http\Requests\UpdateDescriptionRequest;
use App\Models\Description;
use App\Models\Specialist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use function PHPUnit\Framework\isInstanceOf;

class DescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('update', Auth::user()->specialist)) {
            return Inertia::render('Specialist/CreateDescription',['description'=>Auth::user()->specialist->description]);
          
        } else {
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDescriptionRequest $request, Specialist $specialist)
    {
        if ($request->user()->can('update', $specialist) && $specialist->description === null) {
            $specialist->description()->create($request->all());
            return  redirect()->back()->with('message', ['text' => 'Utworzono opis.', 'status' => 'success']);
          
        } else {
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Description $description)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Description $description)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDescriptionRequest $request,Specialist $specialist, Description $description)
    {
        
        if ($specialist->description->id === $description->id  && $request->user()->can('update', $specialist) ) {
            $description->full = $request->full;
            $description->short = $request->short;
            $description->save();
            return  redirect()->back()->with('message', ['text' => 'Zmieniono opis.', 'status' => 'success']);
          
        } else {
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Description $description) : RedirectResponse
    {
        $specialist = Auth::user()->specialist;
        if ($specialist->description->id === $description->id  && Auth::user()->can('update', $specialist) ) {
            $description->delete();
            return  redirect()->back()->with('message', ['text' => 'Usunięto opis.', 'status' => 'success']);
          
        } else {
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
}
