<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SICA\LoginController as SICALoginController;
use App\Http\Controllers\SICA\ImagesController;
use App\Http\Controllers\SICA\DashboardController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\MapController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'checkLogin']);



Route::middleware('auth:web')->group(function () {
    Route::get('show-map', [MapController::class, 'index'])->name('show-map');
    Route::post('/get-tehsils', [MapController::class, 'getTehsils']);
    Route::post('/get-markazes', [MapController::class, 'getMarkazes']);
    Route::post('/fetch-pp-seats', [MapController::class, 'getPPSeats']);
    Route::post('/fetch-na-seats', [MapController::class, 'getNAseats']);
    Route::post('/get-schools', [MapController::class, 'getSchools'])->name('get-schools');
    Route::post('/get-sne-schools', [MapController::class, 'getSNESchools'])->name('get-sne-schools');
    Route::post('/get-schools-ajax', [MapController::class, 'getSchoolsAjax'])->name('get-schools-ajax');
    Route::get('punjab-stats', [MapController::class, 'punjabStats']);
    Route::post('/district-comparison', [MapController::class, 'compareDistricts'])->name('district-comparison');
    Route::get('/teachers-school-wise/{district_id?}/{teacher_count?}', [MapController::class, 'teachersSchoolWise']);
    Route::get('/get-comparison-dropdown', [MapController::class, 'getComparisonDropdown']);
    Route::get('/complaint-form', [ComplaintController::class, 'showForm'])->name('complaint.form');
    Route::post('/submit-complaint', [ComplaintController::class,'storeComplaints'])->name('complaint.submit');
    Route::get('/complaint-listing', [ComplaintController::class, 'complaintList'])->name('complaint.list');
    Route::get('complaint/{complaint_id}', [ComplaintController::class, 'viewComplaint'])->name('complaint.view');
    Route::post('complaint/{complaint_id}/update', [ComplaintController::class, 'updateComplaint'])->name('complaint.update');
    Route::get('/school/images/{id}', [MapController::class, 'showImages'])->name('school.images');
    Route::get('show-map-sne', [MapController::class, 'newSchoolsMap'])->name('show-map-sne');


});
Route::prefix('sica')->group(function () {
    Route::get('login', [SICALoginController::class, 'login']);
    Route::get('logout', [SICALoginController::class, 'logout']);
    Route::post('/login', [SICALoginController::class, 'checkLogin']);

    Route::middleware('auth:sica')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('sica.dashboard');
        Route::get('data-not-submitted', [DashboardController::class, 'data_not_submitted'])->name('sica.datanotsubmitted');
        Route::get('data-unverified', [DashboardController::class, 'data_unverified'])->name('sica.dataunverified');
        Route::get('data-verified', [DashboardController::class, 'data_verified'])->name('sica.data_verified');
        Route::get('data-pending', [DashboardController::class, 'data_pending'])->name('sica.data_pending');
        Route::get('school-emis', [ImagesController::class, 'schoolData'])->name('sica.emis_get_school');
        Route::get('/get-tehsils/{districtId}', [DashboardController::class, 'getTehsils']);
        Route::get('/get-markez/{tehsilId}', [DashboardController::class, 'getMarkez']);
        Route::get('/get-schools/{markezId}', [DashboardController::class, 'getSchools']);

        Route::post('dashboard-stat', [DashboardController::class, 'DashboardStat'])->name('dashboard-stat');

        Route::get('school-data', [ImagesController::class, 'schoolData'])->name('sica.schooldata');
        Route::get('school-images/{emis_code}', [ImagesController::class, 'schoolImages']);
        Route::post('add-remarks', [ImagesController::class, 'addRemarks']);
        Route::get('logout', [SICALoginController::class, 'logout']);
    });
});
