<?php

namespace App\Http\Controllers;

use App\Http\Traits\FilterTrait;
use App\Models\Pair;
use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PairController extends Controller
{
    use FilterTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jsonMinDate = $this->getMinDate();
        $jsonMaxDate = $this->getMaxDate();

        $countDataRows = $this->getCountDataRows();

        return view('src.training.pair', compact('countDataRows', 'jsonMinDate', 'jsonMaxDate'));
    }

/**
    * Filter-settings applySettings; selects vocabularies with given constraints
    * @param Request $request
    * 
    * @return $vocabularies
    */
    public function filterSelect(Request $request){
        $fieldSize = explode('x', $request->fieldSize);

        $fieldColumn = $fieldSize[0];
        $fieldRow = $fieldSize[1];
        $jsonMinDate = $this->getMinDate();
        $jsonMaxDate = $this->getMaxDate();

        $limit = ($fieldSize[0] * $fieldSize[1])/2;

        $countDataRows = $this->getCountDataRows();

        $dateRange = $this->getStartAndEndDate($request);
        $fromDate = $dateRange[0];
        $toDate = $dateRange[1];

        $marker = $this->getMarker($request);
        
        if($request->hdSelectAll == null){
            $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                        ->whereIn('foreign_vocabularies.marker_id', $marker)
                                        ->inRandomOrder()->limit($limit)->get();

        }else{
            $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                        ->inRandomOrder()->limit($limit)->get();

        }

            

        
        $jsVariable = 1;
        $jsonStringPHP = json_encode($vocabularies);
        return view('src.training.pair', compact('vocabularies', 'jsonStringPHP', 'jsVariable', 'countDataRows', 'jsonMinDate', 'jsonMaxDate'));
                                 
    }

}
