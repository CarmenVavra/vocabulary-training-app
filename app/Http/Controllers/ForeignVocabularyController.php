<?php

namespace App\Http\Controllers;

use App\Models\ForeignVocabulary;
use App\Models\Vocabulary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForeignVocabularyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\ForeignVocabulary  $foreignVocabulary
     * @return \Illuminate\Http\Response
     */
    public function show(ForeignVocabulary $foreignVocabulary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ForeignVocabulary  $foreignVocabulary
     * @return \Illuminate\Http\Response
     */
    public function edit(ForeignVocabulary $foreignVocabulary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ForeignVocabulary  $foreignVocabulary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ForeignVocabulary $foreignVocabulary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ForeignVocabulary  $foreignVocabulary
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForeignVocabulary $foreignVocabulary)
    {
        //
    }

    public function setMarker(Request $request){

        header('Content-Type, application/json; charset = utf-8');

        if(strtolower($_SERVER['REQUEST_METHOD']) == 'get'){

            $foreignVocabulary = ForeignVocabulary::where('id', $request->fvid)
                                                    ->where('vocabulary_id', $request->vid)->first();
            
            $foreignVocabulary->marker_id = $request->marker;
            $foreignVocabulary->update();
        
            return response()->json([
                'response'=>'updated'
            ]);
        }        
    }
}
