<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use App\Models\VocabularyVocabulary;
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
        /* ::Peter::
            Model: Vocabulary neue Methode vocabularies() hinzugefügt
        */
        $userId = Auth::user()->id;
        $language_id = session('language_id');
        $language_learn_id = session('language_learn_id');

        //$language_learn_id = session('language_learn_id');
        //$language_sec_id = 3;

    //    $vocabularies = Vocabulary::with('vocabularies')->where('user_id', $userId)->where('language_id', session('language_id'))->orWhere('language_id', session('language_learn_id'))->get();
        $vocabularies = Vocabulary::with('vocabularies')->where('user_id', $userId)->where('language_id', session('language_id'))->get();
        //dd($vocabularies);
        //dd($vocabularies[0]->vocabularies[0]->id);
        //dd($vocabularies[0]->name, $vocabularies[0]->vocabularies[0]->name);
        /*
        Unter attributes siehst du den Datensatz Ausgangssprache und unter relations den dazugehörigen Datensatz
       dd($vocabularies);
        */
        //dd($vocabularies[0]->vocabularies[0]->name);

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
            'firstLangNew'=>'required|max:200',
            'secondLangNew'=>'required|max:200',
        ]);

        $voc1 = [
            'name' => $request->firstLangNew,
            'user_id' => Auth::user()->id,
            'language_id' => session('language_id')
        ];
        $vocInsert1 =  Vocabulary::create($voc1);

        $voc2 = [
            'name' => $request->secondLangNew,
            'user_id' => Auth::user()->id,
            'language_id' => session('language_learn_id')
        ];
        $vocInsert2 =  Vocabulary::create($voc2);

        //::Peter:: vocabularies() Methode im Model vocalbulary und attach erwartet ein Array mit ID's. Durch attach wird die Pivot Tabelle befüllt
        $vocInsert1->vocabularies()->attach([$vocInsert2->id]);

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
    public function edit(Vocabulary $word1 )
    {
        $word2 = $word1->vocabularies()->first();
        return view('/src/vocabulary/edit', compact('word1','word2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vocabulary $word1)
    {
        //dd($vocabularyVocabularies->vocabulary_id, $vocabularyVocabularies->vocabulary_learn_id, $request);

        //dd($request, $vocabularyVocabularies);
         $request->validate([
            'firstLangEdit'=>'required|min:1|max:30',
            'secondLangEdit'=>'required|min:1|max:30'
        ]);

        //Datensatz aus DB lesen
        $word2 = $word1->vocabularies()->first();

        /*
            ::Peter::
            $word1 => Objekt mit den Daten Wort 1 aus der Datenbank
            $word1->name neuer Wert (firstLangEdit) zuweisen und dann ändern ->save()
            Daten nicht in der Pivot Tabelle ändern sondern in der Tabelle  vocabularies
        */

        $word1->name = $request->firstLangEdit;
        $word1->save();
        $word2->name = $request->secondLangEdit;
        $word2->save();

        return redirect()->route('vocabulary.index')->with('success', 'Vokabeln wurden geändert!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vocabulary  $vocabulary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vocabulary $word1)
    {
        $word2 = $word1->vocabularies()->first();
        $word1->delete();
        $word2->delete();
        $word1->vocabularies()->detach([$word2->id]);

        return redirect()->route('vocabulary.index')->with('success', 'Die Vokabeln wurden gelöscht!');
    }
}
