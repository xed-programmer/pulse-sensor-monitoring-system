<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DeviceController;
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
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Device 
    Route::group(['prefix'=>'device', 'as'=>'device.'], function(){
        Route::get('/', [DeviceController::class, 'index'])->name('index');
        Route::post('/', [DeviceController::class, 'store'])->name('store');
        // Route::get('/{device}', [DeviceController::class, 'edit'])->name('edit');
        Route::put('/', [DeviceController::class, 'update'])->name('update');
        Route::delete('/{device}', [DeviceController::class, 'destroy'])->name('delete');
    });
});
