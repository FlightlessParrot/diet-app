<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SpecialistViewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Specialist $specialist)
    {
        $user=Auth::user();
        $specialist->imageUrl=count($specialist->attachment) ? $specialist->attachment[0]->url :null;
        $specialist->services = $specialist->serviceKinds()->get();
        $specialist->cities = $specialist->serviceCities()->get();
        $specialist->stationaryAddresses = $specialist->addresses()->get();
        $specialist->servicePrices = $specialist->prices()->get();
        $specialist->fullDescription = $specialist?->description?->full;
        $reviews = $specialist->reviews()->paginate(20);
        $myReview = Review::where('specialist_id',$specialist->id)->where('user_id',$user->id)->first();
        return Inertia::render('User/SpecialistView',['specialist'=>$specialist, 'reviews'=>$reviews, 'myReview'=>$myReview]);
    }
}
