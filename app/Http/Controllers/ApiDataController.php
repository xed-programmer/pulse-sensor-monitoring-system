<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class ApiDataController extends Controller
{
    private $api_key_value = 'tPmAT5Ab3j7F9';

    public function getDevices(Request $request)
    {
        $request->validate([
            'api_key'=>['required']
        ]);

        if($request->api_key != $this->api_key_value){
            echo [];
        }

        $devices = Device::all();
        $value = [];
        foreach($devices as $d){
            $patient_name = "";
            if(empty($d['patient']['name']) || !isset($d['patient']['name'])){
                $patient_name = "";
            }else{
                $patient_name = $d['patient']['name'];
            }
            array_push($value,[$d['id'],$d['name'],$d['machine_number'],$patient_name]);
        }
        $len = $devices->count();
        $jsonData = [
            "recordsTotal"=>$len,
            "recordsFiltered"=>$len,
            "data"=>$value];
        echo json_encode($jsonData);
    }

    public function getPatients(Request $request)
    {
        $request->validate([
            'api_key'=>['required']
        ]);

        if($request->api_key != $this->api_key_value){
            echo [];
        }

        $patients = Patient::all();
        $value = [];
        foreach($patients as $d){
            array_push($value,[$d['id'],$d['patient_number'],$d['name'],$d['age'],$d['phone']]);
        }
        $len = $patients->count();
        $jsonData = [
            "recordsTotal"=>$len,
            "recordsFiltered"=>$len,
            "data"=>$value];
        echo json_encode($jsonData);
    }

    public function getUserPatients(Request $request, User $user)
    {
        $request->validate([
            'api_key'=>['required']
        ]);

        if($request->api_key != $this->api_key_value){
            echo [];
        }
        $patients = $user->patients()->get();        
        $value = [];
        foreach($patients as $d){
            array_push($value,[$d['id'],$d['patient_number'],$d['name'],$d['age'],$d['phone']]);
        }
        $len = $patients->count();
        $jsonData = [
            "recordsTotal"=>$len,
            "recordsFiltered"=>$len,
            "data"=>$value];
        echo json_encode($jsonData);
    }
}
