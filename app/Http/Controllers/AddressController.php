<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Models\Province;
use App\Models\Specialist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\UnauthorizedException;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Specialist/CreateSpecialistAddress', ['provinces'=>Province::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $address=$request->user()->address()->create($request->validated());
        return redirect()->back();
    }
    public function storeForSpecialist(StoreAddressRequest $request, Specialist $specialist)
    {
        $user=$request->user();
        if($user->can('update',$specialist) )
        {            
            $request->user()->specialist->addresses()->create($request->validated());
            return to_route('language.create')->with('message',['text'=>'Udało się','status'=>'success']);
        }else{
        return redirect()->back()->with('message',['text'=>'Coś poszło nie tak.','status'=>'error']);
        }
        
    }

    public function storeForSpecialistAndRedirectBack(StoreAddressRequest $request, Specialist $specialist)
    {
        $user=$request->user();
        if($user->can('update',$specialist) )
        {            
            $request->user()->specialist->addresses()->create($request->validated());
            return redirect()->back()->with('message',['text'=>'Udało się','status'=>'success']);
        
        
        }else{
        return redirect()->back()->with('message',['text'=>'Coś poszło nie tak.','status'=>'error']);
        }
        
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
        if($request->user()?->address?->id===$address->id)
        {
        $address->update($request->all());
        $address->save();
        
        return Redirect::route('profile.edit');
        }else{
            return redirect()->back()->withErrors(['text'=>'Nie masz uprawnień, aby wykonać tę akcję.']);;
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateForSpecialist(UpdateAddressRequest $request,Specialist $specialist, Address $address)
    {
        if($request->user()?->specialist->addresses()->first()?->id===$address->id && $specialist->id ===$request->user()->specialist->id)
        {
        $address->update($request->all());
      
        
        return Redirect::route('specialist.profile.edit',$specialist->id)->with('message',['text'=>'Udało się zaktualizować adress','status'=>'success' ]);
        }else{
            return redirect()->back()->withErrors(['text'=>'Nie masz uprawnień, aby wykonać tę akcję.']);;
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        
        $user=Auth::user();
        if(($user->address!==null && $user->address->id===$address->id) || 
        ($user->specialist !==null && $user->specialist->addresses()->find($address->id)!==null  ))
        {
            $address->delete();
            return redirect()->back();
        }else{
            return redirect()->back()->withErrors(['text'=>'Nie masz uprawnień, aby wykonać tę akcję.']);
        }
    }
}
