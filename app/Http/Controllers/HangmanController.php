<?php

namespace App\Http\Controllers;

use App\Models\Hangman;
use Illuminate\Http\Request;

class HangmanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('src.training.hangman');
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
     * @param  \App\Models\Hangman  $hangman
     * @return \Illuminate\Http\Response
     */
    public function show(Hangman $hangman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hangman  $hangman
     * @return \Illuminate\Http\Response
     */
    public function edit(Hangman $hangman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hangman  $hangman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hangman $hangman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hangman  $hangman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hangman $hangman)
    {
        //
    }
}
