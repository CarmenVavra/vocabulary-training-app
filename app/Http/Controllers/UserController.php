<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('src.user.index', compact('users'));

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //$user = User::where('id', $user);

        $user = User::where('id', $user->id)->get();      

        return route('user.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if($user->role_id == '1'){
            $role_name = 'Admin';
        }else{
            $role_name = 'User';
        }
        return view('src.user.edit', compact('user', 'role_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=> 'required|min:2|max:100',
            'email'=> 'required|min:2|max:255',
            'password'=>'required|min:8|max:255'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        $user->update($data);
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->training()->delete();
        $user->language()->delete();
        $user->vocabulary()->delete();
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Der Benutzer wurde gelöscht!');
    }


    public function profile(){
        return true;
    }

    public function adminUpdate(Request $request, User $user){
        //dd($request->role_id, $user);

        if(isset($request->role_id)){
            $role_id = '1';
        }else{
            $role_id = '2';
        }

        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['password'] = $user->password;
        $data['role_id'] = $role_id;

        $user->update($data);
        
        return redirect()->route('user.index')->with('success', 'Die Rolle wurde erfolgreich geändert');
    }

    
        /**
     * shows modal to confirm delete
     * @param Vocabulary $vocabulary
     * 
     * @return \Illuminate\Http\Response 
     */
    public function warnDelete(User $user){

        $deleteUser = User::where('id', $user->id)->first();
        $users = User::all();
        
        return view('src.user.index', compact('users', 'deleteUser'));
    }

        /**
     * cancel-button Modal confirm delete
     * 
     * @return \Illuminate\Http\Response 
     */
    public function userCancel(){
        return redirect()->route('user.index');
    }


}
