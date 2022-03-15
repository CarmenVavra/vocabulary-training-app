<?php

namespace App\Http\Controllers;

use App\Models\ForeignVocabulary;
use App\Models\Vocabulary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class VocabularyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                    ->select('foreign_vocabularies.id as fvid', 'foreign_vocabularies.name as fvn', 'vocabularies.id as vid', 'vocabularies.name as vn')
                                    ->where('vocabularies.user_id', Auth::user()->id)
                                    ->where('foreign_vocabularies.language_id', session('foreign_id'))->paginate(50);

        return view('/src/vocabulary/vocabulary', compact('vocabularies'));
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
        $request->validate([
            'firstLangNew'=>'required|max:200', /* Muttersprache */
            'secondLangNew'=>'required|max:200', /* Fremdsprache */
        ]);

        $voc1 = [
            'name' => $request->firstLangNew,
            'user_id' => Auth::user()->id,
            'language_id' => session('language_id')
        ];
        $vocInsert1 =  Vocabulary::create($voc1);

        $voc2 = [
            'name' => $request->secondLangNew,
            'language_id' => session('foreign_id'),
            'vocabulary_id' => $vocInsert1->id,
        ];
        ForeignVocabulary::create($voc2);

        return redirect()->route('vocabulary.index')->with('success', 'Die Vokabeln wurden erfolgreich angelegt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function show(Vocabulary $vocabulary)
    {
        // return redirect()->route('vocabulary.index', compact('vocabulary'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function edit(Vocabulary $vocabulary)
    {       
        $vocabulary = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                ->select('foreign_vocabularies.id as fvid', 'foreign_vocabularies.name as fvn', 'vocabularies.id as vid', 'vocabularies.name as vn')
                                ->where('vocabularies.user_id', Auth::user()->id)
                                ->where('vocabularies.id', $vocabulary->id)->first();

        $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                ->select('foreign_vocabularies.id as fvid', 'foreign_vocabularies.name as fvn', 'vocabularies.id as vid', 'vocabularies.name as vn')
                                ->where('vocabularies.user_id', Auth::user()->id)
                                ->where('foreign_vocabularies.language_id', session('foreign_id'))->get();

        return view('src.vocabulary.vocabulary', compact('vocabulary', 'vocabularies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vocabulary $vocabularies)
    {
        $request->validate([
            'firstLangEdit'=>'required|min:1|max:30',
            'secondLangEdit'=>'required|min:1|max:30'
        ]);

        $vData['name'] = $request->firstLangEdit;
        $vocabularies->update($vData);
         
        $fvData['name'] = $request->secondLangEdit;
        $fvoc = ForeignVocabulary::where('vocabulary_id', $vocabularies->id)->get();

        $fvoc[0]->update($fvData);

        return redirect()->route('vocabulary.index')->with('success', 'Die Vokabeln wurden erfolgreich geändert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vocabulary $deleteVocabulary)
    {
        $fvoc = ForeignVocabulary::where('vocabulary_id', $deleteVocabulary->id)->get();
        $deleteVocabulary->delete();
        $fvoc[0]->delete();

        return redirect()->route('vocabulary.index')->with('success', 'Die Vokabeln wurden erfolgreich gelöscht!');
    }
    
    /**
     * shows modal to confirm delete
     * @param Vocabulary $vocabulary
     * 
     * @return \Illuminate\Http\Response 
     */
    public function warnDelete(Vocabulary $vocabulary){

        $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                ->select('foreign_vocabularies.id as fvid', 'foreign_vocabularies.name as fvn', 'vocabularies.id as vid', 'vocabularies.name as vn')
                                ->where('vocabularies.user_id', Auth::user()->id)
                                ->where('foreign_vocabularies.language_id', session('foreign_id'))->get();
        
        $deleteVocabulary = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                ->select('foreign_vocabularies.id as fvid', 'foreign_vocabularies.name as fvn', 'vocabularies.id as vid', 'vocabularies.name as vn')
                                ->where('vocabularies.user_id', Auth::user()->id)
                                ->where('vocabularies.id', $vocabulary->id)->first();

        return view('src.vocabulary.vocabulary', compact('vocabularies', 'deleteVocabulary'));
    }

    /**
     * cancel-button Modal confirm delete
     * 
     * @return \Illuminate\Http\Response 
     */
    public function vocabularyCancel(){
        $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                    ->select('foreign_vocabularies.id as fvid', 'foreign_vocabularies.name as fvn', 'vocabularies.id as vid', 'vocabularies.name as vn')
                                    ->where('vocabularies.user_id', Auth::user()->id)
                                    ->where('foreign_vocabularies.language_id', session('foreign_id'))->get();

        return redirect()->route('vocabulary.index');
    }

    /**
     * new vocabulary input auutocomplete
    * @param  \Illuminate\Http\Request  $request
    *
    * @return \Illuminate\Http\Response
    */
    public function autocomplete(Request $request){

        header('Content-Type, application/json; charset = utf-8');
        
        if(strtolower($_SERVER['REQUEST_METHOD']) == 'get'){
            //::Peter:: hier sollte noch die Sprache eingeschränkt werden
            $input = Vocabulary::join('foreign_vocabularies', function ($join) {
                                            $join->on('vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id');
                                            $join->on('foreign_vocabularies.language_id', '=', DB::raw(session()->get('foreign_id')));
                                        })
                                    ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                    ->where('vocabularies.user_id', Auth::user()->id)
                                    ->where('vocabularies.name', 'LIKE', "$request->searchString%")
                                    ->orderBy('vocabularies.name')->limit(5)->get();
        
            return response()->json([
                'input'=>$input
            ]);
        } 
    }

    /**
     * creates PDF and shows download-dialog
     * 
     * @return $pdf download-dialog
     */
    public function createPDF(){
        foreach(session('vocabularies') as $vocabulary){
            $vocabularies[] = $vocabulary;
        }

        view()->share ('vocabularies', $vocabularies);
        /* $pdf = App::make('dompdf.wrapper'); */
        $pdf = PDF::loadView('/pdf/vocabulariesList', $vocabularies);
        

        return $pdf->download('/vocs.pdf');
    }
}
