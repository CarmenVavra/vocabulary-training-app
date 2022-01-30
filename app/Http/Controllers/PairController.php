<?php

namespace App\Http\Controllers;

use App\Models\Pair;
use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


/*         $marker = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                ->where('vocabularies.user_id', Auth::user()->id)
                                ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                ->where('foreign_vocabularies.marker_id', '>', 0)->first(); */
        
        $countDataRows = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                    ->where('vocabularies.user_id', Auth::user()->id)
                                    ->where('foreign_vocabularies.language_id', session('foreign_id'))->get()->count();

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

    public function checkDate(Request $request){

       
        header('Content-Type, application/json; charset = utf-8');

        if(strtolower($_SERVER['REQUEST_METHOD']) == 'get'){
        
            $dateDataRow = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('foreign_vocabularies.id')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$request->start, $request->end])->groupBy('foreign_vocabularies.id')->get()->count();

            return response()->json([
                'dateDataRow'=>$dateDataRow,
                'start'=>$request->start,
                'end'=>$request->end
            ]);
          }

    }

    public function checkDifficultyLevel(Request $request){
        header('Content-Type, application/json; charset = utf-8');

        if(strtolower($_SERVER['REQUEST_METHOD']) == 'get'){
        
            $diffDataRow = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('foreign_vocabularies.id')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$request->start, $request->end])
                                        ->where('foreign_vocabularies.marker_id', $request->marker)->groupBy('foreign_vocabularies.id')->get()->count();


            return response()->json([
                'diffDataRow'=>$diffDataRow,
                'start'=>$request->start,
                'end'=>$request->end,
                'marker'=>$request->marker
            ]);
          }
    }

    public function selectAll(Request $request){

        header('Content-Type, application/json; charset = utf-8');

        if(strtolower($_SERVER['REQUEST_METHOD']) == 'get'){

        $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                    ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                    ->where('vocabularies.user_id', Auth::user()->id)
                                    ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                    ->whereBetween('foreign_vocabularies.created_at', [$request->start, $request->end])
                                    ->inRandomOrder()->get();
        return response()->json([
            'vocabulariesCount'=>$vocabularies->count(),
            'vocabularies'=>$vocabularies,
            'start'=>$request->start,
            'end'=>$request->end
        ]);
        
        
        }


    }

    public function filterSelect(Request $request){

        //dd($request->hdSelectAll);
        $fieldSize = explode('x', $request->fieldSize);
        $fieldColumn = $fieldSize[0];
        $fieldRow = $fieldSize[1];

        $limit = ($fieldSize[0] * $fieldSize[1])/2;
        
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



/* 

        "daterange" => "01/23/2022 - 02/28/2022" --> $fromDate, $toDate
        "diffRed" => "1"    isset($request->diffRed)               isset($request->diffYellow)
        "diffGreen" => "3"  isset($request->diffGreen)
        "fieldSize" => "4x3"  $limit
 */
        if(isset($request->diffRed)){
            $markerRed = $request->diffRed;
        }else{
            $markerRed = 9;
        }

        if(isset($request->diffYellow)){
            $markerYellow = $request->diffYellow;
        }else{
            $markerYellow = 9;
        }

        if(isset($request->diffGreen)){
            $markerGreen = $request->diffGreen;
        }else{
            $markerGreen = 9;
        }
        
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
        return view('src.training.pair', compact('vocabularies','jsonStringPHP', 'jsVariable'));

  
                                 
    }

}
