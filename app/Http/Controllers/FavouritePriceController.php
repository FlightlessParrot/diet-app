<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouritePriceController extends Controller
{
    public function associate(Price $price) : RedirectResponse
    {
        $specialist = Auth::user()->specialist;
        if($price->specialist->id === $specialist->id)
        {
            $specialist->favouritePrice()->associate($price->id);
            $specialist->save();
          return  redirect()->back()->with('message', ['text' => 'Wybrano cenę.', 'status' => 'success']);
        }
        else{
        return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tek.', 'status' => 'error']);
        }      
    }
}
