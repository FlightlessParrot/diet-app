<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ServiceKind;
use App\Models\Specialist;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FindSpecialistController extends Controller
{
    /**
     * Find specialist accounts by filters
     */
    public function find(Request $request)
    {

        // query by search term - initial query
        $search='%'.$request->searchTerm.'%';
        $myQuery=Specialist::where(fn (Builder $query) =>
            $query->whereAny(['name', 'surname','title'],'like', $search)
            ->orWhereHas('serviceCities',function (Builder $query) use ($search)  {
                $query->where('name', 'like', $search);
            })
        );
        
        $categories=$request->categories;
        
        // query by chosen categories
        if(isset($categories) && count($categories)>0)
        {
            $myQuery = $myQuery->whereHas('categories',function (Builder $query) use ($categories)  {
                $query->whereIn('categories.id', $categories);
            });
           
        }

        // query by chosen service kinds
        $services=$request->services;
        if(isset($services) && count($services)>0)
        {
            $myQuery = $myQuery->whereHas('serviceKinds',function (Builder $query) use ($services)  {
                $query->whereIn('service_kinds.id', $services);
            });
            
        }

        
        //------
        $paginatedResults=$myQuery->paginate(15);
        

        return  Inertia::render('FindSpecialist',['categories'=>Category::all(),'services'=>ServiceKind::all(),'paginatedSpecialists'=>$paginatedResults]);
        
    }
}
