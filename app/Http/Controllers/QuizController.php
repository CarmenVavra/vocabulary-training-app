<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marker = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                ->where('vocabularies.user_id', Auth::user()->id)
                                ->where('foreign_vocabularies.marker_id', '>', 0)->first();

        return view('src.training.quiz', compact('marker'));
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

    public function filterSelect(Request $request){

        //dd($request);
        $rangeDate = explode(' - ', $request->daterange);

        $fromDate = DateTime::createFromFormat('m/d/Y', $rangeDate[0]);
        $error = DateTime::getLastErrors();
        if( $error['warning_count'] == 0 && $error['error_count'] == 0 ){
            $fromDate->format('Y-m-d');
        }
        else{
            echo 'Hier ist ein Fehler passiert';
        }

        

        $toDate = DateTime::createFromFormat('m/d/Y', $rangeDate[1]);
        $error = DateTime::getLastErrors();
        if( $error['warning_count'] == 0 && $error['error_count'] == 0 ){
            $toDate->format('Y-m-d');
        }
        else{
            echo 'Hier ist ein Fehler passiert';
        }
        
        $direction = $request->radioDirection;
       
        //marker
        $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
        ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
        ->where('vocabularies.user_id', Auth::user()->id)
        ->where('foreign_vocabularies.language_id', session('foreign_id'))
        ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])->get();
        
        return view('src.training.quiz', compact('vocabularies', 'direction'));
    }



}