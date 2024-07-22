<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ServiceKind;
use App\Models\Specialist;
use App\Supports\SpecialistFinder\SpecialistFinder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FindSpecialistController extends Controller
{
    public function unregisteredUserFind(Request $request)
    {
        $finder = new SpecialistFinder($request->searchTerm);

        $finder->querybyCategories($request->categories);
     
        $finder->queryServiceKinds($request->services);

        $finder->paginateResults(16);

        $paginatedResults= $finder->getResults();
        return  Inertia::render('Guest/FindSpecialist',
        ['categories'=>Category::all(),'services'=>ServiceKind::all(),'paginatedSpecialists'=>$paginatedResults]);
    }
    /**
     * Find specialist accounts by filters
     */
    public function find(Request $request)
    {
        $finder = new SpecialistFinder($request->searchTerm);

        $finder->querybyCategories($request->categories);
     
        $finder->queryServiceKinds($request->services);

        $finder->paginateResults(16);

        $paginatedResults= $finder->getResults();
        return  Inertia::render('User/FindSpecialist',
        ['categories'=>Category::all(),'services'=>ServiceKind::all(),'paginatedSpecialists'=>$paginatedResults]);
        
    }
}
