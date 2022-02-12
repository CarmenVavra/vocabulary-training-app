<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('src.training.training');
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
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Training $training)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        //
    }

    public function setHighscore($trainingType, $seconds, $mistakes){
        $highscore = $mistakes * 3 + $seconds;
        $training = Training::where('user_id', Auth::user()->id)
                            ->where('training_type_id', $trainingType)
                            ->where('language_id', session('language_id'))
                            ->where('foreign_id', session('foreign_id'))->first();
        
        if($training == null){
            $data['user_id'] = Auth::user()->id;
            $data['training_type_id'] = $trainingType;
            $data['language_id'] = session('language_id');
            $data['foreign_id'] = session('foreign_id');
            $data['highscore'] = $highscore;

            Training::create($data);
        }else{
            $data['user_id'] = Auth::user()->id;
            $data['training_type_id'] = $trainingType;
            $data['language_id'] = session('language_id');
            $data['foreign_id'] = session('foreign_id');
            $data['highscore'] = $highscore;
            
            $training->update($data);
        }
        
        return $this;
    }

    public function getHighscore($trainingType){
        $highscore = Training::select('highscore')
                            ->where('user_id', Auth::user()->id)
                            ->where('training_type_id', $trainingType)
                            ->where('language_id', session('language_id'))
                            ->where('foreign_id', session('foreign_id'))->first();
    
        return $highscore;
    }
}
