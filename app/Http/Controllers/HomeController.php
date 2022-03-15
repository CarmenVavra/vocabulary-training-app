<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\User;
use DateTime;
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
        
        $user = User::where('id', Auth::user()->id)->first();
        $data['last_login'] = new DateTime($user->login_date);
        $data['login_date'] = new DateTime('now');
        $user->update($data);
        
        $language = Language::where('user_id', Auth::user()->id)->where('main_language', 1)->first();
        session(['language_id'=>$language->id, 'language_name'=>$language->name]);
        
        $languages = Language::where('user_id', Auth::user()->id)->where('main_language', 0)->orderBy('name')->get();
        return view('/home', compact('languages'));
    }
}
