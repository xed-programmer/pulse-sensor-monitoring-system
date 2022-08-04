<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Pulse;
use Illuminate\Http\Request;

class PulseDataController extends Controller
{
    private $api_key_value = 'tPmAT5Ab3j7F9'; 
    public function index(Request $request)
    {
        $request->validate([
            'api_key'=>'required',
            'id'=>['required','exists:devices,machine_number'],
            'hr'=>'required',
            'spo2'=>'required'
        ]);

        if($request->api_key != $this->api_key_value){
            echo "api is invalid";
        }

        $device = Device::where('machine_number', $request->id)->firstOrFail();            
        Pulse::create([
            'device_id'=>$device->id,
            'patient_id'=>$device->patient_id,
            'hr'=>$request->hr,
            'spo2'=>$request->spo2
        ]);
        echo "ok";
    }

    public function getPatientPulse(Request $request)
    {
        $devices = Device::all();
        $devices_id = [];
        $patients_id = [];
        foreach ($devices as $d) {
            array_push($patients_id, $d['patient_id']);
        }    
        foreach ($devices as $d) {
            array_push($devices_id, $d['id']);
        }

        $pulses = Pulse::with(['patient'])
        ->whereHas('patient', function($q) use ($patients_id){
            $q->whereIn('id', $patients_id);
        })
        ->whereHas('device', function($q) use ($devices_id){
            $q->whereIn('id', $devices_id);
        })
        ->limit(10)        
        ->get()
        ->groupBy('patient_id');        

        echo json_encode($pulses);
    }
}
