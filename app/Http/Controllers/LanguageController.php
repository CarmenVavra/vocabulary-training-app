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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Languages  $languages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        //
    }

    public function setCookie(Request $request){
        $foreign_id = Language::select('id', 'name')->where('short_name', $request->foreignLanguage)->get();
        session(['foreign_id'=>$foreign_id[0]->id, 'foreign_name'=>$foreign_id[0]->name]);
        return redirect()->route('welcome.index');
    }
}