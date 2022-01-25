<?php

namespace App\Http\Controllers;

use App\Models\ForeignVocabulary;
use App\Models\Vocabulary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                                    ->where('foreign_vocabularies.language_id', session('foreign_id'))->get();
   
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

        return redirect()->route('vocabulary.index');
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
        $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                    ->select('foreign_vocabularies.id as fvid', 'foreign_vocabularies.name as fvn', 'vocabularies.id as vid', 'vocabularies.name as vn')
                                    ->where('vocabularies.user_id', Auth::user()->id)
                                    ->where('vocabularies.id', $vocabulary->id)->get();
        
        return view('/src/vocabulary/edit', compact('vocabularies'));
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

        return redirect()->route('vocabulary.index')->with('success', 'Vokabeln wurden geändert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vocabulary $vocabulary)
    {
        $fvoc = ForeignVocabulary::where('vocabulary_id', $vocabulary->id)->get();
        $vocabulary->delete();
        $fvoc[0]->delete();

        return redirect()->route('vocabulary.index')->with('success', 'Die Vokabeln wurden gelöscht!');
    }
}
