<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AddressController extends Controller
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
    public function store(StoreAddressRequest $request)
    {
        $address=$request->user()->address()->create($request->validated());
        return redirect()->back()->with("success",true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        if($request->user()->id===$address->user_id)
        {
        $address->update($request->all());
        $address->save();
        
        return Redirect::route('profile.edit');
        }else{
            return response(['message'=>'Nie masz uprawnień, aby wykonać tę akcję.'],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $user=Auth::user();
        if($user->address!==null && $user->address->id===$address->id)
        {
            $address->delete();
            return redirect(route('profile.edit'));
        }else{
            return response(['message'=>'Nie masz uprawnień, aby wykonać tę akcję.'],401);
        }
    }
}
