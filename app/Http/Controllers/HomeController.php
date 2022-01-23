<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $language = Language::where('user_id', Auth::user()->id)->where('main_language', true)->get();
        session(['language_id'=>$language[0]->id]);
        
        $languages = Language::where('user_id', Auth::user()->id)->where('main_language', false)->orderBy('name')->get();
        return view('/home', compact('languages'));
    }
}
