<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Daten für Selectbox
        $languages = Language::where('user_id', Auth::user()->id)->where('main_language', false)->orderBy('name')->get();
        return view('/home', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        $languages = Language::where('user_id', Auth::user()->id)->where('main_language', false)->orderBy('name')->get();
        return view('/home', compact('languages'));
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
            'name'=>'required|min:3|max:50'
        ]); 

        $data = [
            'name' => $request->name,
            'short_name' => substr($request->name, 0, 3),
            'user_id' => Auth::user()->id
        ];

        Language::create($data);
        return redirect()->route('post.language.index')->with('success', 'Die Sprache '.$request->name.' wurde erstellt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        return view('src.language.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        $request->validate([
            'name'=>'required|min:2',
            'short_name'=>'required|min:3|max:4'
        ]);

        $language->update($request->all());

        return redirect()->route('language.admin.index')->with('success', 'Die Sprache wurde geändert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Languages  $languages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        $language->delete();

        return redirect()->route('language.admin.index')->with('success', 'Die Sprache wurde gelöscht!');
    }

    /**
     * set cookie for ForeignLanguage id, name
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function setCookie(Request $request){
        $foreign_id = Language::select('id', 'name')->where('short_name', $request->foreignLanguage)->get();
        session(['foreign_id'=>$foreign_id[0]->id, 'foreign_name'=>$foreign_id[0]->name]);
        return redirect()->route('vocabulary.index');
    }

    /**
     * admin-area selects all languages
     * 
     * @return \Illuminate\Http\Response
     */
    public function adminIndex(){

        $languages = Language::leftJoin('users', 'users.id', '=', 'languages.user_id')
                                ->select('users.id as uid', 'users.name as uname', 'languages.user_id as luid', 'languages.name as lname', 'languages.id as lid', 'languages.short_name as lshort')->get();
                   
        
        return view('src.language.index', compact('languages'));
    }

        /**
     * shows modal to confirm delete
     * @param Vocabulary $vocabulary
     * 
     * @return \Illuminate\Http\Response 
     */
    public function warnDelete(Language $language){
        $languages = Language::leftJoin('users', 'users.id', '=', 'languages.user_id')
                                ->select('users.id as uid', 'users.name as uname', 'languages.user_id as luid', 'languages.name as lname', 'languages.id as lid', 'languages.short_name as lshort')->get();

        $deleteLanguage = $language;

        return view('src.language.index', compact('languages', 'deleteLanguage'));
    }

            /**
     * cancel-button Modal confirm delete
     * 
     * @return \Illuminate\Http\Response 
     */
    public function languageCancel(){
        return redirect()->route('language.admin.index');
    }
}