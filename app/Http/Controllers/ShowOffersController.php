<?php

namespace App\Http\Controllers;

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

    public function show(Offer $offer)
    {
        return Inertia::render('Specialist/Commerce/Offer',['offer'=>$offer]);
    }
}
