<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class ApiDataController extends Controller
{
    private $api_key_value = 'tPmAT5Ab3j7F9';

    public function getDevice(Request $request)
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
            array_push($value,[$d['id'],$d['name'],$d['machine_number'],$d['patient']['name'],$d['id']]);
        }
        $len = $devices->count();
        $jsonData = [
            "recordsTotal"=>$len,
            "recordsFiltered"=>$len,
            "data"=>$value];
        echo json_encode($jsonData);
    }
}
