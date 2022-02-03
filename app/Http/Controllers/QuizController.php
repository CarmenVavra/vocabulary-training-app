<?php

namespace App\Http\Controllers;

use App\Http\Traits\FilterTrait;
use App\Models\ForeignVocabulary;
use App\Models\Quiz;
use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
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

        return view('src.training.quiz', compact('countDataRows'));
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
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
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
        //dd($request);
        $jsVariable = 1;
        $limit = $request->countQuestions;
        
        $dateRange = $this->getStartAndEndDate($request);
        $fromDate = $dateRange[0];
        $toDate = $dateRange[1];

        $countDataRows = $this->getCountDataRows();
        $marker = $this->getMarker($request);
        $markerRed = $marker[0];
        $markerYellow = $marker[1];
        $markerGreen = $marker[2];

/*         if('dir1' == $request->radioDirection){
            $tablename = 'vocabularies';
        }else if('dir2' == $request->radioDirection){
            $tablename = 'foreign_vocabularies';
        } */
        
        if($request->hdSelectAll == null){

            $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                        ->where('foreign_vocabularies.marker_id', $markerRed)
                                        ->orWhere('foreign_vocabularies.marker_id', $markerYellow)
                                        ->orWhere('foreign_vocabularies.marker_id', $markerGreen)
                                        ->inRandomOrder()->limit($limit)->get();

        }else{
            $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                        ->inRandomOrder()->limit($limit)->get();
        }

/*         $fakeVocabularies = ForeignVocabulary::join('vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('foreign_vocabularies.name as fvn')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->where('foreign_vocabularies.vocabulary_id', '<>', 'vocabularies.id')
                                        ->inRandomOrder()->limit(3)->get(); */

            $jsonStringPHP = json_encode($vocabularies);
            $radioDirection = $request->radioDirection;

            return view('src.training.quiz', compact('vocabularies','jsonStringPHP', 'jsVariable', 'radioDirection', 'countDataRows'));

    }

    public function fetchFake(Request $request){

        header('Content-Type, application/json; charset = utf-8');

        if(strtolower($_SERVER['REQUEST_METHOD']) == 'get'){
      
                $fakeVoc = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                                ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                                ->where('vocabularies.user_id', Auth::user()->id)
                                                ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                                ->where('foreign_vocabularies.vocabulary_id', '<>', 'vocabularies.id')
                                                ->inRandomOrder()->limit(3)->get();
        return response()->json([
            'fakeVoc'=>$fakeVoc, 
            'radioDirection'=>$request->radioDirection
        ]);
        
        
        }
    }

}