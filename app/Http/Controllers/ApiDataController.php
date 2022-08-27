<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class ApiDataController extends Controller
{
    private $api_key_value = 'tPmAT5Ab3j7F9';

    // FUNCTION PARA KUNIN ANG LAHAT NG DATA NG DEVICES
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

    // FUNCTION PARA MAKUHA ANG LAHAT NG DATA NG PATIENT
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

    // FUNCTION PARA MAKUHA ANG DATA NG LAHAT NG PATIENT NA CONNECTED SA USER
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

    // FUNCTION PARA MAKUHA LAHAT NG DATA NG USER
    public function getUsers(Request $request)
    {
        $request->validate([
            'api_key'=>['required']
        ]);

        if($request->api_key != $this->api_key_value){
            echo [];
        }

        $users = User::with('role')->orderBy('role_id', 'ASC')->get();
        $value = [];
        foreach($users as $d){
            array_push($value,[$d['id'],$d['name'],$d['email'],$d['role']['name'], $d['role_id']]);
        }
        $len = $users->count();
        $jsonData = [
            "recordsTotal"=>$len,
            "recordsFiltered"=>$len,
            "data"=>$value];
        echo json_encode($jsonData);
    }
}
