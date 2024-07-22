<?php
namespace App\Supports\SpecialistFinder;

interface SpecialistFinderInterface
{
    /**
     * Extend query.
     * @param array|null $categories;
     * @return void
     */
    public function querybyCategories(array|null $categories) : void;

    /**
     * Extend query.
     * @param array|null $serviceKinds
     * @return void
     */
    public function queryServiceKinds(array|null $serviceKinds) : void;

    /**
     * Prepare paginated results.
     * @param int $howManyPerPage
     * @return void
     */
    public function paginateResults(int $howManyPerPage) : void;

     /**
     * Prepare paginated results.
     * 
     * @return object|array
     */
    public function getResults() : object|array;

   

}