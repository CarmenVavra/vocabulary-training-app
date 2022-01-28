<?php

namespace App\Http\Controllers;

use App\Http\Traits\FilterTrait;

class QuizFilterController extends Controller
{
    use FilterTrait;
    

    /* public function setDateRange(array $dateRange){
        $this->dateRange[] = $dateRange;
        return $this;
    }

    public function setDifficultyLevel(array $difficulyLevel){
        $this->difficulyLevel[] = $difficulyLevel;
        return $this;
    }

    public function setDirection(string $direction){
        $this->direction = $direction;
        return $this;
    }

    public function setSortOrder(string $sortOrder){
        $this->sortOrder = $sortOrder;
        return $this;
    }

    public function getDateRange(){
        return $this->dateRange;
    }

    public function getDifficultyLevel(){
        return $this->difficulyLevel;
    }

    public function getDirection(){
        return $this->direction;
    }

    public function getSortOrder(){
        return $this->sortOrder;
    }
 */
}
