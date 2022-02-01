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
        
        $countDataRows = $this->getCountDataRows();

        return view('src.training.pair', compact('countDataRows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pair  $pair
     * @return \Illuminate\Http\Response
     */
    public function show(Pair $pair)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pair  $pair
     * @return \Illuminate\Http\Response
     */
    public function edit(Pair $pair)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pair  $pair
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pair $pair)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pair  $pair
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pair $pair)
    {
        //
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

        $limit = ($fieldSize[0] * $fieldSize[1])/2;
        
        $dateRange = $this->getStartAndEndDate($request);
        $fromDate = $dateRange[0];
        $toDate = $dateRange[1];

        $marker = $this->getMarker($request);
        $markerRed = $marker[0];
        $markerYellow = $marker[1];
        $markerGreen = $marker[2];
        
        if($request->hdSelectAll == null){
            $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                        ->where('foreign_vocabularies.marker_id', $markerRed)
                                        ->orWhere('foreign_vocabularies.marker_id', $markerYellow)
                                        ->orWhere('foreign_vocabularies.marker_id', $markerGreen)->inRandomOrder()->limit($limit)->get();

        }else{
            $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                        ->inRandomOrder()->limit($limit)->get();

        }
        
        //dd($vocabularies->count());
            

        
        $jsVariable = 1;
        $jsonStringPHP = json_encode($vocabularies);             
        return view('src.training.pair', compact('vocabularies', 'jsonStringPHP', 'jsVariable'));

  
                                 
    }

}
