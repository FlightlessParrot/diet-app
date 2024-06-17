<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SpecialistViewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Specialist $specialist)
    {
        $specialist->imageUrl=$specialist->attachment[0]?->url;
        $specialist->services = $specialist->serviceKinds()->get();
        $specialist->cities = $specialist->serviceCities()->get();
        $specialist->stationaryAddresses = $specialist->addresses()->get();
        $specialist->servicePrices = $specialist->prices()->get();
        $specialist->fullDescription = $specialist?->description?->full;
        return Inertia::render('User/SpecialistView',['specialist'=>$specialist]);
    }
}
