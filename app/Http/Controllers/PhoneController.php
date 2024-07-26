<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeForSpecialist( Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Phone $phone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Phone $phone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Phone $phone)
    {
        $request->validate(['number'=>'string|required|max:16']);
        if($request->user()->can('update',$phone))
        {
            $phone->number=$request->number;

            $phone->save(); 
            return  redirect()->back()->with('message', ['text' => 'Zmieniono numer telefonu.', 'status' => 'success']);
          
        } else {
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phone $phone)
    {
        //
    }
}
