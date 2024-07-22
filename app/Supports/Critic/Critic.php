<?php
namespace App\Supports\Critic;
use App\Models\Specialist;

class Critic implements CriticInterface
{
    protected $specialist;
    public function __construct(Specialist $specialist)
    {
        $this->specialist=$specialist;
    }
    public function criticize()
    {
       $grade= $this->getAverageGrade();
       $this->saveGrade($grade);
    }

    public function getAverageGrade(): int
    {

        $reviews = $this->specialist->reviews()->get();
        $divider = count($reviews) ? count($reviews) : 1; 
        $totalReviewGrade=0;
        foreach( $reviews as $review)
        {
            $totalReviewGrade+=(int) $review->grade;
        }
        $avarageGrade = (int) ceil($totalReviewGrade/$divider);
        return $avarageGrade;
    }

    public function saveGrade(int $grade): bool
    {
    $statistic=$this->specialist->statistic;
    $statistic->review_grade=$grade;
    $statistic->save();

    return true;
    }
}