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
        return Inertia::render('User/SpecialistView',['specialist'=>$specialist]);
    }
}
