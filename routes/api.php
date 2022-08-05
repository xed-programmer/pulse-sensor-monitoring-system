<?php

use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\ApiDataController;
use App\Http\Controllers\PulseDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('pulse-data', [PulseDataController::class, 'index'])->name('pulse.data');
Route::post('patientpulse', [PulseDataController::class, 'getPatientPulse'])->name('patient.pulse');
Route::post('device-data', [ApiDataController::class, 'getDevice'])->name('device.data');
Route::get('admin/device/edit', [DeviceController::class, 'edit'])->name('admin.device.edit');