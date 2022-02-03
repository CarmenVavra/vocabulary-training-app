<?php
namespace App\Http\Traits;

use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait FilterTrait{

    /**
     * checks the count of voccabularies without any settings.
     * 
     * @return vocabulary count
     */
    public function getCountDataRows(){
        return Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                            ->where('vocabularies.user_id', Auth::user()->id)
                            ->where('foreign_vocabularies.language_id', session('foreign_id'))->get()->count();
    }

    public function getStartAndEndDate(Request $request){
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

        $dateRange[0] = $fromDate;
        $dateRange[1] = $toDate;

        return $dateRange;

    }

    public function getMarker(Request $request){

        if(isset($request->diffRed)){
            $markerRed = 1;
        }else{
            $markerRed = 9;
        }

        if(isset($request->diffYellow)){
            $markerYellow = 2;
        }else{
            $markerYellow = 9;
        }

        if(isset($request->diffGreen)){
            $markerGreen = 3;
        }else{
            $markerGreen = 9;
        }

        return [$markerRed, $markerYellow, $markerGreen];
    }

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

            if(in_array('diffRed', $request->markerArray)){
                $markerRed = 1;
            }else{
                $markerRed = 9;
            }

            if(in_array('diffYellow', $request->markerArray)){
                $markerYellow = 2;
            }else{
                $markerYellow = 9;
            }

            if(in_array('diffGreen', $request->markerArray)){
                $markerGreen = 3;
            }else{
                $markerGreen = 9;
            }

            $diffDataRow = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('foreign_vocabularies.id')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->whereBetween('foreign_vocabularies.created_at', [$request->start, $request->end])
                                        ->where('foreign_vocabularies.marker_id', $markerRed)
                                        ->orWhere('foreign_vocabularies.marker_id', $markerYellow)
                                        ->orWhere('foreign_vocabularies.marker_id', $markerGreen)
                                        ->groupBy('foreign_vocabularies.id')->get()->count();


            return response()->json([
                'diffDataRow'=>$diffDataRow,
                'start'=>$request->start,
                'end'=>$request->end,
                'marker'=>$request->marker, 
                'markerArray'=>$request->markerArray
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






