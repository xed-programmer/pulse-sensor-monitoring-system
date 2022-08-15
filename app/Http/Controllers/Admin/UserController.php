<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.user')->with(['roles'=>$roles]);
    }

    public function store(Request $request)
    {
        $request->validate([            
            'name'=>['required','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,id'],            
        ]);

        $role = Role::where('id', $request->role)->firstOrFail();
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role_id' => $role->id
        ]);

        if ($user) {
            $request->session()->flash('message', 'User Data Added Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'User Data Added Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('admin.user.index');
    }

    public function edit(Request $request)
    {
        $request->validate(['id'=>['required']]);
        $user = User::find($request->id);
        return Response::json($user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:users,id'],
            'name'=>['required','max:255'],
            'role' => ['required', 'exists:roles,id']
        ]);

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->role_id = $request->role;
        if ($user->save()) {
            $request->session()->flash('message', 'User Data Updated Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'User Data Updated Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('admin.user.index');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => ['required','exists:users,id']
        ]);
        $user = User::find($request->id);
        if ($user->delete()) {
            $request->session()->flash('message', 'User Data Deleted Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'User Data Deleted Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('admin.user.index');
    }
}
