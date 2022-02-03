<?php

namespace App\Http\Controllers;

use App\Http\Traits\FilterTrait;
use App\Models\Learning;
use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class LearningController extends Controller
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

        return view('src.training.learning', compact('countDataRows'));
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
     * @param  \App\Models\Learning  $learning
     * @return \Illuminate\Http\Response
     */
    public function show(Learning $learning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Learning  $learning
     * @return \Illuminate\Http\Response
     */
    public function edit(Learning $learning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Learning  $learning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Learning $learning)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Learning  $learning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Learning $learning)
    {
        //
    }

    public function filterSelect(Request $request){

        $countDataRows = $this->getCountDataRows();

        $dateRange = $this->getStartAndEndDate($request);
        $fromDate = $dateRange[0];
        $toDate = $dateRange[1];

        $sortOrder = $request->radioSortorder;
        
        $direction = $request->radioDirection;

        $marker = $this->getMarker($request);
        $markerRed = $marker[0];
        $markerYellow = $marker[1];
        $markerGreen = $marker[2];

        if('dir1' == $direction){
            $tablename = 'vocabularies';
        }else if('dir2' == $direction){
            $tablename = 'foreign_vocabularies';
        }

        if('random' == $sortOrder){

            if($request->hdSelectAll == null){
                $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                            ->where('foreign_vocabularies.marker_id', $markerRed)
                                            ->orWhere('foreign_vocabularies.marker_id', $markerYellow)
                                            ->orWhere('foreign_vocabularies.marker_id', $markerGreen)
                                            ->inRandomOrder()->get();            
            }else{
                $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                            ->inRandomOrder()->get();
            }


        }else{
            if($request->hdSelectAll == null){
                $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                            ->where('foreign_vocabularies.marker_id', $markerRed)
                                            ->orWhere('foreign_vocabularies.marker_id', $markerYellow)
                                            ->orWhere('foreign_vocabularies.marker_id', $markerGreen)
                                            ->orderBy("$tablename.name", $sortOrder)->get();
            }else{
                $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                            ->orderBy("$tablename.name", $sortOrder)->get();

            }
       }

        return view('src.training.learning', compact('vocabularies', 'direction', 'countDataRows'));
    }
}
