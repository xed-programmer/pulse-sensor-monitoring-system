<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PatientController extends Controller
{

    // FUNCTION PARA I-VIEW ANG PATIENT TAB
    public function index()
    {        
        $patients = Patient::all();
        return view('admin.patient.index')->with([
            'patients'=>$patients
        ]);
    }

    // FUNCTION PARA ISHOW ANG PULSES DATA NG PATIENT
    public function show(Request $request)
    {
        $request->validate(['id'=>['required', 'exists:patients,id']]);        
        return view('admin.patient.show')->with(['patient_id'=>$request->id]);
    }

    // FUNCTION PARA MAG ADD NG NEW PATIENT
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','max:255'],
            'age' =>['required','numeric'],
            'phone' => ['required','regex:/(09)[0-9]{9}/','min:11']
        ]);
        
        $unique_id = null;
        do {
            $unique_id = uniqid('P-');
            $unique_id = strtoupper($unique_id);
            $patient = Patient::where('patient_number', $unique_id)->get();
        } while ($patient->count()>0);
        
        $patient = Patient::create([
            'name' => $request->name,
            'age' => $request->age,
            'phone' => $request->phone,
            'patient_number' => $unique_id
        ]);

        if ($patient) {
            $request->session()->flash('message', 'Patient Data Added Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'Patient Data Added Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('admin.patient.index');
    }

    // FUNCTION PARA KUNIN ANG DATA NG PATIENT NA IEEDIT
    public function edit(Request $request)
    {
        $request->validate(['id'=>['required']]);
        $patient = Patient::find($request->id);
        return Response::json($patient);
    }

    // FUNCTION PARA I-UPDATE ANG DATA NG PATIENT
    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:patients,id'],
            'name'=>['required','max:255'],
            'age' =>['required','numeric'],
            'phone' => ['required','regex:/(09)[0-9]{9}/','min:11']
        ]);

        $patient = Patient::find($request->id);
        $patient->name = $request->name;
        $patient->age = $request->age;
        $patient->phone = $request->phone;
        if ($patient->save()) {
            $request->session()->flash('message', 'Patient Data Updated Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'Patient Data Updated Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('admin.patient.index');
    }

    // FUNCTION PARA I-DELETE ANG DATA NG PATIENT
    public function destroy(Request $request)    
    {
        $request->validate([
            'id' => ['required','exists:patients,id']
        ]);
        $patient = Patient::find($request->id);
        if ($patient->delete()) {
            $request->session()->flash('message', 'Patient Data Deleted Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'Patient Data Deleted Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('admin.patient.index');
    }
}
