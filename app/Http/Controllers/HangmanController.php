<?php

namespace App\Http\Controllers;

use App\Models\Hangman;
use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HangmanController extends Controller
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

        return view('src.training.hangman', compact('marker'));
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
        $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                    ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                    ->where('vocabularies.user_id', Auth::user()->id)
                                    ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                    ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])->get();
        
        return view('src.training.hangman', compact('vocabularies', 'direction'));
    }



}