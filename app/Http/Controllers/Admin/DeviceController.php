<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DeviceController extends Controller
{
    // ANG CONTROLLER NA TO AT PARA SA PAGMANIPULATE NG DATA NG DEVICE
    public function index()
    {
        $devices = Device::with('patient')->get();
        $patients = Patient::all();
        return view('admin.device')->with(['devices'=>$devices, 'patients'=>$patients]);
    }


    // ANG FUNCTION NA TO AY PARA I-STORE AND NEW DEVICE SA DATABASE
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required'],
            'machine_number'=>['required','unique:devices,machine_number']
        ]);

        Device::create($request->only(['name','machine_number']));        
        return back();
    }

    // FUNCTION PARA KUNIN ANG DATA NG DEVICE NA IEEDIT
    public function edit(Request $request)
    {        
        $request->validate([
            'id'=>['required']
        ]);
        $device = Device::with('patient')
        ->where('id',$request->id)
        ->firstOrFail();        
        return Response::json($device);
    }

    // FUNCTION PARA I-UPDATE ANG DEVICE DATA
    public function update(Request $request)
    {        
        $request->validate([
            'id' => ['required'],
            'name' => ['required'],
            'machine_number' => ['required', 'unique:devices,machine_number,'.$request->id.',id'],            
        ]);
        
        $device = Device::find($request->id);

        $device->name = $request->name;
        $device->machine_number = $request->machine_number;
        $device->patient_id = $request->patient;

        if ($device->save()) {
            $request->session()->flash('message', 'Device Data Updated Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'Device Data Updated Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('admin.device.index');
    }

    // FUNCTION PARA I-DELETE ANG DEVICE DATA
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:devices,id']
        ]);
        
        $device = Device::find($request->id);
        if ($device->delete()) {
            $request->session()->flash('message', 'Device Data Deleted Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'Device Data Deleted Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('admin.device.index');
    }
}
