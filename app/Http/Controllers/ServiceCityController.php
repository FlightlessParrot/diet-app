<?php

namespace App\Http\Controllers;

use App\Models\ServiceCity;
use App\Models\ServiceKind;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceCityController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceCity $serviceCity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceCity $serviceCity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceCity $serviceCity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCity $serviceCity)
    {
        $user=Auth::user();
        if($user->can('delete',$serviceCity))
        {
            $user->specialist->serviceCities()->detach($serviceCity->id);
            if(count($user->specialist->serviceCities()->get())===0)
            {
                 $user->specialist->serviceKinds()->detach(ServiceKind::where('name','mobile')->first());
            }
            return redirect()->back()->with('message',['text'=>'Pomyślnie edytowano dane.','status'=>'success']);
        }else{
            return redirect()->back()->withErrors(['text'=>'Coś poszło nie tak.']);
        }
    }
}
