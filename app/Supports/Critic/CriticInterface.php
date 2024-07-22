<?php
namespace App\Supports\Critic;

interface CriticInterface {
    /**
     * Change grades, reviews, and sum it up.
     * 
     */
    public function criticize();

    /**
     * Get avarage review grade.
     * 
     * @return int
     */
    public function getAverageGrade() : int;

    /**
     * Save new avarageGrade
     * 
     * @param int
     * 
     * @return boolean
     */
    public function saveGrade(int $grade) : bool;

}