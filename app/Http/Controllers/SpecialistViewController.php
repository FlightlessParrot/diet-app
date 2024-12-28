<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SpecialistViewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function user(Specialist $specialist) : Response
    {
        $user=Auth::user();

        //specialist details
        $specialist->imageUrl=count($specialist->attachment) ? $specialist->attachment[0]->url :null;
        $specialist->services = $specialist->serviceKinds()->get();
        $specialist->cities = $specialist->serviceCities()->get();
        $specialist->stationaryAddresses = $specialist->addresses()->get();
        $specialist->servicePrices = $specialist->prices()->get();
        $specialist->fullDescription = $specialist?->description?->full;
        $specialist->targets=$specialist->targets()->get();
        $specialist->user;
        //reviews
        $reviews = $specialist->reviews()->paginate(20);
        $myReview = Review::where('specialist_id',$specialist->id)->where('user_id',$user->id)->first();


        //courses
        $courses = $specialist->courses()->orderByDesc('start_date')->get();

        //languages
        $languages = $specialist->languages()->get();
        //create statistic model if it does not exit
        if(!$specialist->statistic)
        {
            $specialist->statistic()->create();
        }

        //increment view counter on statistic model
        $statistic=$specialist->statistic;
        $statistic->view_counter++;
        $statistic->save();

        //get statistic
        $specialist->statistic;
        
        //socialMedias
        $socialMedias = $specialist->socialMedias()->get();
        return Inertia::render('User/SpecialistView',['specialist'=>$specialist, 'reviews'=>$reviews, 'myReview'=>$myReview, 
        'courses' =>$courses, 'languages'=>$languages, 'socialMedias'=>$socialMedias, 'specializations'=>$specialist->specializations()->get()]);
    }

    public function guest(Specialist $specialist) : Response
    {
        //specialist details
        $specialist->imageUrl=count($specialist->attachment) ? $specialist->attachment[0]->url :null;
        $specialist->services = $specialist->serviceKinds()->get();
        $specialist->cities = $specialist->serviceCities()->get();
        $specialist->stationaryAddresses = $specialist->addresses()->get();
        $specialist->servicePrices = $specialist->prices()->get();
        $specialist->fullDescription = $specialist?->description?->full;
        $specialist->targets=$specialist->targets()->get();
        $specialist->user;
        //reviews
        $reviews = $specialist->reviews()->paginate(20);


        //courses
        $courses = $specialist->courses()->orderByDesc('start_date')->get();

        //languages
        $languages = $specialist->languages()->get();
        //create statistic model if it does not exit
        if(!$specialist->statistic)
        {
            $specialist->statistic()->create();
        }

        //increment view counter on statistic model
        $statistic=$specialist->statistic;
        $statistic->view_counter++;
        $statistic->save();

        //get statistic
        $specialist->statistic;
        
        //socialMedias
        $socialMedias = $specialist->socialMedias()->get();
        return Inertia::render('Guest/SpecialistView',['specialist'=>$specialist, 'reviews'=>$reviews,  
        'courses' =>$courses, 'languages'=>$languages, 'socialMedias'=>$socialMedias,'specializations'=>$specialist->specializations()->get()]);
    }
}
