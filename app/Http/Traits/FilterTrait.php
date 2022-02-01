<?php
namespace App\Http\Traits;

use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait FilterTrait{

   /**
    * Filter-settings datetrange; checks if vocabularies exist in daterange
    * @param Request $request
    * 
    * @return JSON-Object response
    */
    public function checkDate(Request $request){

        
        header('Content-Type, application/json; charset = utf-8');

        if(strtolower($_SERVER['REQUEST_METHOD']) == 'get'){
        
            $dateDataRow = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('foreign_vocabularies.id')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$request->start, $request->end])->groupBy('foreign_vocabularies.id')->get()->count();

            $markerDataRow = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('foreign_vocabularies.id')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$request->start, $request->end])
                                        ->where('foreign_vocabularies.marker_id', '>', '0')->groupBy('foreign_vocabularies.id')->get()->count();
            return response()->json([
                'dateDataRow'=>$dateDataRow,
                'markerDataRow'=>$markerDataRow,
                'start'=>$request->start,
                'end'=>$request->end
            ]);
          }

    }

   /**
    * Filter-settings difficultyLevel; checks if vocabularies exist in difficultyLevel
    * @param Request $request
    * 
    * @return JSON-Object response
    */
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

   /**
    * Filter-settings selectAll Button; selects all vocabularies in given daterange without marker (difficultyLevel) settings
    * @param Request $request
    * 
    * @return JSON-Object response
    */
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

    
}






