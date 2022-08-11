<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function showPatient(Request $request)
    {
        if(!$request->has('id')){
            return redirect()->route('user.index');
        }
        return view('user.patient')->with('patient_id', $request->id);
    }

    public function storePatient(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $request->validate([
            'patient_number'=>['required','exists:patients,patient_number']
        ]);
        $patient = Patient::where('patient_number', $request->patient_number)->firstOrFail();
        if($user->hasPatient($patient)){
            $request->session()->flash('message', 'Patient Added Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }else{
            $user->patients()->attach($patient->id);

            $request->session()->flash('message', 'Patient Added Successfully');
            $request->session()->flash('result', 'success');
        }

        return redirect()->route('user.index');
    }

    public function removePatient(Request $request)
    {
        $res = auth()->user()->patients()->detach($request->id);
        if($res){
            $request->session()->flash('message', 'Patient Removed Successfully');
            $request->session()->flash('result', 'success');
        }else{
            $request->session()->flash('message', 'Patient Removed Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('user.index');
    }
}
