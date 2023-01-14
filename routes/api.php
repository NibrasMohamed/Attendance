<?php

use App\Http\Controllers\AppHumanResources\AttendanceController;
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

Route::post('/upload-excel',[ AttendanceController::class, 'uploadExcel']);
Route::get('/view-attendance/{id}', [AttendanceController::class, 'getEmployeeAttendance']);
Route::get('/get-attendance-list', [AttendanceController::class, 'getAttendanceList']);
