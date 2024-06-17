<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDescriptionRequest;
use App\Http\Requests\UpdateDescriptionRequest;
use App\Models\Description;
use App\Models\Specialist;

class DescriptionController extends Controller
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
    public function store(StoreDescriptionRequest $request, Specialist $specialist)
    {
        if ($request->user()->can('update', $specialist) && $specialist->description === null) {
            $specialist->description()->create($request->all());
            return  redirect()->back()->with('message', ['text' => 'Zmieniono ikonę.', 'status' => 'success']);
          
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
    public function update(UpdateDescriptionRequest $request, Description $description)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Description $description)
    {
        //
    }
}
