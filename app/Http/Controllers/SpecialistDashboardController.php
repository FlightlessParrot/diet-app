<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SpecialistDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $notifications = Auth::user()->specialist->notifications()->paginate();
        return Inertia::render('Specialist/SpecialistDashboard',['notifications'=>$notifications]);
    }
}
