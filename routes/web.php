<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PulseDataController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// Route::group(['middleware'=>['auth']], function (){
// });
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'admin', 'as'=>'admin.'], function(){
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/data', [PulseDataController::class, 'getPatientPulse']);
    
    // Device 
    Route::group(['prefix'=>'device', 'as'=>'device.'], function(){
        Route::get('/', [DeviceController::class, 'index'])->name('index');
        Route::post('/', [DeviceController::class, 'store'])->name('store');
        // Route::get('/{device}', [DeviceController::class, 'edit'])->name('edit');
        Route::put('/', [DeviceController::class, 'update'])->name('update');
        Route::delete('/', [DeviceController::class, 'destroy'])->name('delete');
    });

    // Patient
    Route::group(['prefix'=>'patient', 'as'=>'patient.'], function(){
        Route::get('/', [PatientController::class, 'index'])->name('index');
        Route::post('/', [PatientController::class, 'store'])->name('store');
        // Route::get('/{device}', [PatientController::class, 'edit'])->name('edit');
        Route::put('/', [PatientController::class, 'update'])->name('update');
        Route::delete('/', [PatientController::class, 'destroy'])->name('delete');
    });
});

Route::group(['prefix'=>'user', 'as'=>'user.'], function(){
    Route::get('/', [UserController::class, 'index'])->name('index');    

    Route::group(['prefix'=>'patient', 'as'=>'patient.'], function(){
        Route::get('/', [UserController::class,'showPatient'])->name('show');
        Route::post('/', [UserController::class,'storePatient'])->name('store');        
        Route::delete('/', [UserController::class,'removePatient'])->name('delete');        
    });
});
