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
        $countDataRows = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                    ->where('vocabularies.user_id', Auth::user()->id)
                                    ->where('foreign_vocabularies.language_id', session('foreign_id'))->get()->count();

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

            if($request->radioDirection == 'dir1'){
                $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                            ->where('foreign_vocabularies.marker_id', $markerRed)
                                            ->orWhere('foreign_vocabularies.marker_id', $markerYellow)
                                            ->orWhere('foreign_vocabularies.marker_id', $markerGreen)->inRandomOrder()->limit($limit)->get();

                $fakeVocForeign = ForeignVocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                                    ->select('foreign_vocabularies.name as fvn')
                                                    ->where('vocabularies.user_id', Auth::user()->id)
                                                    ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                                    ->where('foreign_vocabularies.vocabulary_id', '<>', 'vocabularies.id')
                                                    ->inRandomOrder()->limit($limit*3)->get();

            }else if($request->radioDirection == 'dir2'){
                $foreign_vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                            ->where('foreign_vocabularies.marker_id', $markerRed)
                                            ->orWhere('foreign_vocabularies.marker_id', $markerYellow)
                                            ->orWhere('foreign_vocabularies.marker_id', $markerGreen)->inRandomOrder()->limit($limit)->get();
                
                $fakeVocLang = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('vocabularies.name as vn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->where('foreign_vocabularies.vocabulary_id', '<>', 'vocabularies.id')
                                            ->inRandomOrder()->limit($limit*3)->get();
            }




            

        }else{

            if($request->radioDirection == 'dir1'){

                $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                            ->inRandomOrder()->limit($limit)->get();

/*                 $fakeVocForeign = ForeignVocabulary::join('vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                                    ->select('foreign_vocabularies.name as fvn')
                                                    ->where('vocabularies.user_id', Auth::user()->id)
                                                    ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                                    ->where('foreign_vocabularies.vocabulary_id', '<>', 'vocabularies.id')
                                                    ->inRandomOrder()->get(); */

                $jsonStringPHP = json_encode($vocabularies);
                //$jsonStringPHPFakeVoc = json_encode($fakeVocForeign);
                $radioDirection = json_encode($request->radioDirection);
                return view('src.training.quiz', compact('vocabularies','jsonStringPHP', 'jsVariable', 'radioDirection'));

            }else if($request->radioDirection == 'dir2'){

                $vocabularies = ForeignVocabulary::join('vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->whereBetween('foreign_vocabularies.created_at', [$fromDate, $toDate])
                                            ->inRandomOrder()->limit($limit)->get();
                
/*                 $fakeVocLang = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                            ->select('vocabularies.name as vn')
                                            ->where('vocabularies.user_id', Auth::user()->id)
                                            ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                            ->where('foreign_vocabularies.vocabulary_id', '<>', 'vocabularies.id')
                                            ->inRandomOrder()->get(); */
                
                $jsonStringPHP = json_encode($vocabularies);
                //$jsonStringPHPFakeVoc = json_encode($fakeVocLang);
                $radioDirection = json_encode($request->radioDirection);
                return view('src.training.quiz', compact('vocabularies','jsonStringPHP', 'jsVariable', 'radioDirection'));
            }


        }
        
        //dd($vocabularies->count());
    }

    public function fetchFake(Request $request){

        header('Content-Type, application/json; charset = utf-8');

        if(strtolower($_SERVER['REQUEST_METHOD']) == 'get'){
            if($request->radioDirection == 'dir1'){
                
                $fakeVoc = ForeignVocabulary::join('vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('foreign_vocabularies.name as fvn')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->inRandomOrder()->limit(3)->get();

            }else if($request->radioDirection == 'dir2'){
                
                $fakeVoc = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                        ->select('vocabularies.name as fvn')
                                        ->where('vocabularies.user_id', Auth::user()->id)
                                        ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                        ->inRandomOrder()->limit(3)->get();                            
            }

        return response()->json([
            'fakeVoc'=>$fakeVoc, 
            'radioDirection'=>$request->radioDirection
        ]);
        
        
        }
    }

}