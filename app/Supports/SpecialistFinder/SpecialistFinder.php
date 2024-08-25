<?php
namespace App\Supports\SpecialistFinder;

use App\Models\Specialist;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SpecialistFinder implements SpecialistFinderInterface
{
    private $query;
    private $results;

    /**
     * query by search term - prepare initial query
     * @param string|null $searchTerm
     */
    public function __construct(string|null $searchTerm)
    {
        $search='%'.$searchTerm.'%';
        $this->query=Specialist::where(fn (Builder $query) =>
            $query->whereAny(['name', 'surname','title'],'like', $search)
            ->orWhereHas('serviceCities',function (Builder $query) use ($search)  {
                $query->where('name', 'like', $search);
            })
            ->orWhereHas('addresses',function (Builder $query) use ($search)  {
                $query->where('city', 'like', $search);
            })
        );
    }
    /**
     * Prepare query by chosen categories.
     * 
     * @param array|null $categories
     * @return void
     */
    public function querybyCategories(array|null $categories) : void
    {
        // Prepare query by chosen categories.
        if(isset($categories) && count($categories)>0)
        {
            $this->query = $this->query->whereHas('categories',function (Builder $query) use ($categories)  {
                $query->whereIn('categories.id', $categories);
            });
           
        }
    }

    /**
     * Prepare query by chosen service kinds.
     * @param array|null $services
     * @return void
     */
    public function queryServiceKinds(array|null $services) : void
    {
        if(isset($services) && count($services)>0)
        {
            $this->query = $this->query->whereHas('serviceKinds',function (Builder $query) use ($services)  {
                $query->whereIn('service_kinds.id', $services);
            });
            
        }
    }

    public function paginateResults(int $howManyPerPage) : void
    {
        $paginatedResults=$this->query->where('active', true)->orderByDesc('found_counter')->paginate($howManyPerPage);
        $results=$paginatedResults->map(function (Specialist $specialist){

            if(!$specialist->statistic)
            {
                $specialist->statistic()->create();
            }
            
            //increment the counter
            $specialist->found_counter++;
            $specialist->save();

            //hydrate with related models
            $specialist = $this->hydrateSpecialist($specialist);
            return $specialist;
        });
        $paginatedResults->data=$results;
        $this->results=$paginatedResults;
    }
    /**
     * Resuls getter
     * @return array|object
     */
    public function getResults() : array|object
    {
        return $this->results;
    }

    public function hydrateSpecialist(Specialist $specialist) : Specialist
    {
        $user = Auth::user();
        $specialist->services = $specialist->serviceKinds()->get();
        $specialist->cities = $specialist->serviceCities()->limit(6)->get();
        $specialist->addresses = $specialist->addresses()->limit(6)->get();
        $specialist->image = $specialist->icon;
        $specialist->statistic;
        $specialist->favourite =$user ? 
        $user->favouriteSpecialists()->find($specialist->id)!==null :
        false;
        $specialist->targets=$specialist->targets()->get();
        return $specialist;
    }
  
}