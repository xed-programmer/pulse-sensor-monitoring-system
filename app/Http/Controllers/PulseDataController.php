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

    public function getPatientPulse()
    {
        $devices = Device::all();
        $array_pulse = array();

        foreach ($devices as $d) {
            $pulse = Pulse::with(['patient'])
            ->where('patient_id', $d['patient_id'])
            ->where('device_id', $d['id'])
            ->limit(10)
            ->get()
            ->groupBy('device_id');
            // $array_pulse = $pulse;
            array_push($array_pulse, $pulse);
        }        
        echo json_encode($array_pulse);
    }
}
