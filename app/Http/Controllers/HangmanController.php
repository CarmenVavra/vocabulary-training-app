<?php

namespace App\Http\Controllers;

use App\Http\Traits\FilterTrait;
use App\Models\ForeignVocabulary;
use App\Models\Hangman;
use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

        //dd(Route::currentRouteName());
        $countDataRows = $this->getCountDataRows();

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

        $dateRange = $this->getStartAndEndDate($request);
        $fromDate = $dateRange[0];
        $toDate = $dateRange[1];

        $direction = $request->radioDirection;
       
        $marker = $this->getMarker($request);
        $markerRed = $marker[0];
        $markerYellow = $marker[1];
        $markerGreen = $marker[2];

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