<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();        
        return view('profile.index')->with('user', $user);
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        $user->name = $request->name;
        
        if($user->save()){
            $request->session()->flash('message', 'User Update Successfully');
            $request->session()->flash('result', 'success');
        }else{
            $request->session()->flash('message', 'User Update Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('profile.index');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        if(!Hash::check($request->current_password,$user->password)){
            $request->session()->flash('message', 'Password Update Unsuccessfully!');
            $request->session()->flash('result', 'error');            
        }else{
            $user->password = $request->password;
            if($user->save()){
                $request->session()->flash('message', 'Password Update Successfully');
                $request->session()->flash('result', 'success');
            }else{
                $request->session()->flash('message', 'Password Update Unsuccessfully!');
                $request->session()->flash('result', 'error');
            }
        }

        return redirect()->route('profile.index');
    }

}
