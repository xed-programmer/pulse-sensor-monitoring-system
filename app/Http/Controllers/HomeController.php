<?php

namespace App\Http\Controllers;

use App\Models\Pulse;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
