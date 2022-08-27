<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Patient;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        $dLen = $devices->count();
        $pLen = Patient::count();
        $uLen = User::count();
        return view('admin.index')->with([
            'devices'=>$devices,
            'dLen'=>$dLen,
            'pLen'=>$pLen,
            'uLen'=>$uLen,
        ]);
    }
}
