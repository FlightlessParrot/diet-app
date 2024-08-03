<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSpecialist;
use App\Http\Requests\UpdateSpecialist;
use App\Models\MyRole;
use App\Models\Province;
use App\Models\Specialist;
use App\Models\Category;
use App\Models\Course;
use App\Models\Language;
use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Orchid\Attachment\File;

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
           $specialist=$user->specialist()->create($request->all());
           $phone = new Phone();
           $phone->number=$request->number;
           $specialist->phone()->save($phone);

           $user->myRole()->associate(MyRole::where('name','specialist')->first());
           $user->save();
           
           return to_route('course.create')->with('message',['text'=>'Utworzono profil specjalisty.','status'=>'success']);
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
        $iconUrl=null;
        if(isset($specialist->icon))
        {
            $iconUrl = $specialist->icon->url;
        }
        if(Auth::user()->can('view',$specialist))
        {
            return Inertia::render('Specialist/Profile/EditSpecialist',['provinces'=>Province::All(), 'addresses'=> $specialist->addresses()->get(), 
            'serviceCities'=>$specialist->serviceCities()->get(),'serviceKinds'=>$specialist->serviceKinds()->get(), 
            'checkedCategories'=>$specialist->categories()->get()->map(fn ($e) => $e->id),
            'categories'=>Category::all(), 'prices'=>$specialist->prices()->get(), 
            'avatarUrl'=>Auth::user()->specialist->attachment()->first()?->url(),
            'iconUrl'=>$iconUrl, 'description'=>$specialist->description, 'courses'=>$specialist->courses()->orderByDesc('start_date')->get(),
            'languages'=>$specialist->languages()->get()]);
        }else{
            return response('Nie masz uprawnień, aby wykonać tę akcje.',401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecialist $request, Specialist $specialist)
    {
        if($request->user()->can('update',$specialist))
        {
            $specialist->name=$request->name;
            $specialist->surname = $request->surname;
            $specialist->title = $request->title;
            $specialist->update();
            return redirect()->back()->with('message',['text'=>'Pomyślnie edytowano dane.','status'=>'success']);
        }else{
            return redirect()->back()->withErrors(['text'=>'Coś poszło nie tak.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Specialist $specialist)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);
        $user=Auth::user();
        if($user->cannot('delete',$specialist)){
           
        return to_route('specialist.dashboard')->withErrors(['text'=>'Nie udało się usunąć profilu']);
        }else{
           if($specialist->address!==null)
           {
            $specialist->address()->first()->delete();
           }
           $specialist->delete();
           $user->myRole()->associate(MyRole::where('name','user')->first());
           $user->save();
           return to_route('dashboard')->with('message',['text'=>'Usunięto profil specjalisty.','status'=>'warn']);
        }
    }

    public function storeAvatar(Request $request, Specialist $specialist)
    {
        $user=$request->user();
        $currentAttachment=$user->specialist->attachment()->first();
        if($currentAttachment!==null)
        {
            $currentAttachment->delete();
        }
        $path='specialist/avatars';
        $file = new File($request->file('avatar'));
        $attachment = $file->path($path)->load();
        $user->specialist->attachment()->attach($attachment);
        return redirect()->back()->with('message',['text'=>'Pomyślnie edytowano dane.','status'=>'success']);
        
    }

}
