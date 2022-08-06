<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('patient')->get();
        $patients = Patient::all();
        return view('admin.device')->with(['devices'=>$devices, 'patients'=>$patients]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required'],
            'machine_number'=>['required','unique:devices,machine_number']
        ]);

        Device::create($request->only(['name','machine_number']));        
        return back();
    }

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

    public function destroy(Request $request, Device $device)
    {
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
