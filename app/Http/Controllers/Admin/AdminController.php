<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return view('admin.index')->with([
            'devices'=>$devices
        ]);
    }
}
