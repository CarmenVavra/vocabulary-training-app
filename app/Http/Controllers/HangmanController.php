<?php

namespace App\Http\Controllers;

use App\Http\Traits\FilterTrait;
use App\Models\ForeignVocabulary;
use App\Models\Hangman;
use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HangmanController extends Controller
{
    use FilterTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countDataRows = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                    ->where('vocabularies.user_id', Auth::user()->id)
                                    ->where('foreign_vocabularies.language_id', session('foreign_id'))->get()->count();

        return view('src.training.hangman', compact('countDataRows'));
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
     * @param  \App\Models\Hangman  $hangman
     * @return \Illuminate\Http\Response
     */
    public function show(Hangman $hangman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hangman  $hangman
     * @return \Illuminate\Http\Response
     */
    public function edit(Hangman $hangman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hangman  $hangman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hangman $hangman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hangman  $hangman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hangman $hangman)
    {
        //
    }

    public function filterSelect(Request $request){

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
        $vocabularies = ForeignVocabulary::join('vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('foreign_vocabularies.name as fvn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                            ->inRandomOrder()->limit(1)->get();
        $vocJsonStringPHP = json_encode($vocabularies);
        return view('src.training.hangman', compact('vocabularies', 'direction', 'vocJsonStringPHP'));
    }



}