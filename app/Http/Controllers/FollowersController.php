<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use App\Models\User;
use App\Supports\SpecialistFinder\SpecialistFinder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use function PHPUnit\Framework\returnSelf;

class FollowersController extends Controller
{
    public function followSpecialist(Specialist $specialist) : RedirectResponse
    {
        $user = Auth::user();

        $user->favouriteSpecialists()->attach($specialist->id);

        return redirect()->back();
    }

    public function unfollowSpecialist (Specialist $specialist) : RedirectResponse
    {
        $user = Auth::user();

        $user->favouriteSpecialists()->detach($specialist->id);

        return redirect()->back();
    }

    public function favouriteSpecialists()
    {
        $user = Auth::user();

        $specialists=$user->favouriteSpecialists()->paginate(16);
        
        // $hydrate=function (Specialist $specialist)use ($user){
        //     $specialist->services = $specialist->serviceKinds()->get();
        //     $specialist->cities = $specialist->serviceCities()->limit(6)->get();
        //     $specialist->addresses = $specialist->addresses()->limit(6)->get();
        //     $specialist->image = $specialist->icon;
        //     $specialist->statistic;
        //     $specialist->favourite = $user->favouriteSpecialists()->find($specialist->id)!==null;
        //     return $specialist;
        // };
        $finder = new SpecialistFinder('');
        
        $data = new Collection($specialists);
        $data = $specialists->map(function (Specialist $specialist) use ($finder){

           return $finder->hydrateSpecialist($specialist);
        });
        $specialists->data=$data;
        return Inertia::render('User/FavouriteSpecialists',['specialists'=>$specialists]);
    }
}
