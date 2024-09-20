<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Offer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowOffersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        
        return Inertia::render('Specialist/Commerce/Offers',['offers'=>Offer::all()]);
    }

    public function show(Request $request, Offer $offer)
    {
        $discount=null;
        $missing=false;
        if(isset($request->code) && $request->code !== '')
        {
          $discount = Discount::where('code',$request->code)->first(); 
          if(!$discount)
          {
            $missing=true;
          } 
        }
        
        return Inertia::render('Specialist/Commerce/Offer',['offer'=>$offer, 'discount'=>$discount,'missing'=>$missing,'code'=>$request->code, 'discounts'=>Discount::all()]);
    }
}
