<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Public routes of authtication
Route::controller(\App\Http\Controllers\api\LoginController::class)->prefix('svis')->group(function() {
    Route::post('/login', 'login');
});
Route::middleware(['auth:sanctum'])->prefix('svis')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\api\LoginController::class, 'logout']);
    Route::post('uploadImages', [\App\Http\Controllers\api\ImagesController::class, 'uploadImages']);
    Route::post('checkEmail', [\App\Http\Controllers\api\LoginController::class, 'checkEmail']);
    Route::post('verifyOtp', [\App\Http\Controllers\api\LoginController::class, 'verifyOtp']);
    Route::post('updatePassword', [\App\Http\Controllers\api\LoginController::class, 'updatePassword']);

    Route::get('get_remarks/{emis_code}', [\App\Http\Controllers\api\ImagesController::class, 'getRemarks']);
    Route::get('get_status_school/{emis_code}', [\App\Http\Controllers\api\ImagesController::class, 'getSchoolstatus']);
});