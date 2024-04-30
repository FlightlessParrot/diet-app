<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSpecialist;
use App\Models\Province;
use App\Models\Role;
use App\Models\ServiceCity;
use App\Models\ServiceKind;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SpecialistController extends Controller
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
        if(Auth::user()->cannot('create',Specialist::class)){
            return to_route('profile.edit')->withErrors(['text'=>'Już posiadasz profil.']);
        }
        else{
            return Inertia::render("Specialist/CreateSpecialist");
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSpecialist $request)
    {
        $user=$request->user();
        if($user->cannot('create',Specialist::class)){
        return to_route('specialist.create')->withErrors(['text'=>'Nie udało się utworzyć profilu']);
        }else{
           $user->specialist()->create($request->all());
           $user->role()->associate(Role::where('name','specialist')->first());
           $user->save();
           return to_route('specialist.address.create')->with('message',['text'=>'Utworzono profil specjalisty.','status'=>'success']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialist $specialist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialist $specialist)
    {
        if(Auth::user()->can('view',$specialist))
        {
            return Inertia::render('Specialist/Profile/EditSpecialist',['provinces'=>Province::All(), 'hasAddress'=> $specialist->addresses()->first()!==null, 'addresses'=> $specialist->addresses()->get(), 
            'serviceCities'=>$specialist->serviceCities()->get(),'serviceKinds'=>$specialist->serviceKinds()->get(), 'categories'=>$specialist->categories()->get()]);
        }else{
            return response('Nie masz uprawnień, aby wykonać tę akcje.',401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateSpecialist $request, Specialist $specialist)
    {
        if($request->user()->can('update',$specialist))
        {
            $specialist->name=$request->name;
            $specialist->surname = $request->surname;
            $specialist->title = $request->title;
            $specialist->update();
            return redirect()->back()->with('message',['text'=>'Pomyśłnie edytowano dane.','status'=>'success']);
        }else{
            return redirect()->back()->withErrors(['text'=>'Coś poszło nie tak.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialist $specialist)
    {
        $user=Auth::user();
        if($user->cannot('delete',$specialist)){
           
        return to_route('specialist.dashboard')->withErrors(['text'=>'Nie udało się usunąć profilu']);
        }else{
           if($specialist->address!==null)
           {
            $specialist->address()->first()->delete();
           }
           $specialist->delete();
           $user->role()->associate(Role::where('name','user')->first());
           $user->save();
           return to_route('dashboard')->with('message',['text'=>'Usunięto profil specjalisty.','status'=>'warn']);
        }
    }
}
