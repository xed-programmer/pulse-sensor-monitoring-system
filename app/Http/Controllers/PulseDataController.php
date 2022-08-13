<?php

namespace App\Http\Controllers;

use App\Jobs\PulseReportSendEmail;
use App\Models\Device;
use App\Models\Patient;
use App\Models\Pulse;
use App\Models\User;
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

        $hr = $request->hr;
        $spo2 = $request->spo2;

        if($request->api_key != $this->api_key_value){
            echo "api is invalid";
        }

        $device = Device::where('machine_number', $request->id)->firstOrFail();            
        Pulse::create([
            'device_id'=>$device->id,
            'patient_id'=>$device->patient_id,
            'hr'=>$hr,
            'spo2'=>$spo2
        ]);

        if($hr > 100 || $hr < 60 || $spo2 < 90){     
            echo "sending email";
            $details = (Object) Array();

            $users = User::whereHas('patients', function($q) use ($device){
                $q->where('patient_id', $device->patient_id);
            })->get();

            foreach($users as $user){
                $details->user = $user;
                $details->hr = $hr;
                $details->spo2 = $spo2;
                
                PulseReportSendEmail::dispatch($details);                
            }
        }
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

    public function getUserPatientPulse($id)
    {        
        $pulse = Pulse::with(['patient'])
        ->where('patient_id', $id)
        ->limit(10)
        ->get();        
        echo json_encode($pulse);
    }
}
