<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/queue-work', function(){
    echo Artisan::call('queue:work --stop-when-empty');
});
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth']], function (){
    Route::group(['middleware'=>['checkrole:admin'],'prefix'=>'admin', 'as'=>'admin.'], function(){
        Route::get('/', [AdminController::class, 'index'])->name('index');    
        
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
            Route::get('/show', [PatientController::class, 'show'])->name('show');
            Route::put('/', [PatientController::class, 'update'])->name('update');
            Route::delete('/', [PatientController::class, 'destroy'])->name('delete');
        });
    
        // User
        Route::group(['prefix'=>'user', 'as'=>'user.'], function(){
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
            // Route::get('/{device}', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/', [AdminUserController::class, 'destroy'])->name('delete');
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

    Route::group(['prefix'=>'profile', 'as'=>'profile.'], function(){
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/u/{user}', [ProfileController::class, 'updateUser'])->name('update.user');
        Route::put('/p/{user}', [ProfileController::class, 'updatePassword'])->name('update.password');
    });
});

