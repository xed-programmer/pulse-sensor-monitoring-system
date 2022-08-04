<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>['auth']], function (){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::group(['prefix'=>'admin', 'as'=>'admin.'], function(){
    Route::get('/', [AdminController::class, 'index']);
});
