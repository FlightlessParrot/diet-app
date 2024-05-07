<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePriceRequest;
use App\Http\Requests\UpdatePriceRequest;
use App\Models\Price;
use App\Models\Specialist;

class PriceController extends Controller
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
    public function store(StorePriceRequest $request) 
    {
        $user=$request->user();
        if($user->can('create',Price::class))
        {
            foreach($request->prices as $price)
            {
            $user->specialist->prices()->create($price);
            }
            return redirect()->back()->with('message',['text'=>'Pomyśłnie edytowano dane.','status'=>'success']);
        }else{
            return redirect()->back()->withErrors(['text'=>'Coś poszło nie tak']);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Price $price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Price $price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePriceRequest $request,Specialist $specialist, Price $price)
    {
        $user=$request->user();
        if($user->can('update',$price))
        {
            $price->name=$request->name;
            $price->price=$request->price;
            $price->save();
            return redirect()->back()->with('message',['text'=>'Pomyśłnie edytowano dane.','status'=>'success']);
        }else{
            return redirect()->back()->withErrors(['text'=>'Coś poszło nie tak']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialist $specialist, Price $price)
    {
        $user=auth()->user();
        if($user->can('delete',$price))
        {
            $price->delete();
            return redirect()->back()->with('message',['text'=>'Pomyśłnie usunięto cenę.','status'=>'success']);
        }else{
            return redirect()->back()->withErrors(['text'=>'Nie masz uprawnień, aby usunąć cenę.']);
        }
    }
}
