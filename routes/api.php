<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Master\StatusController;
use App\Http\Controllers\Master\StreetController;
use App\Http\Controllers\Sikoja\GaleryController;
use App\Http\Controllers\Sikoja\SikojaController;
use App\Http\Controllers\Master\VillageController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\InstanceController;
use App\Http\Controllers\SikojaDispotition\FileController;
use App\Http\Controllers\SikojaDispotition\SikojadispController;

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


//sikoja
Route::get('sikoja', [SikojaController::class, 'index']);
Route::get('sikoja/{id}', [SikojaController::class, 'show']);
Route::post('sikoja', [SikojaController::class, 'store']);
Route::post('uploadGalery', [GaleryController::class, 'uploadGaleries']);

//sikojadips
Route::get('sikojadisp', [SikojadispController::class, 'index']);
Route::get('sikojadisp/{id}', [SikojadispController::class, 'show']);

Route::get('category', [CategoryController::class, 'index']);
Route::get('instance', [InstanceController::class, 'index']);
Route::get('street', [StreetController::class, 'index']);
Route::get('village', [VillageController::class, 'index']);
//Auth
Route::post('login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('resend-verify-email', [AuthController::class, 'resendEmailVerification']);
    Route::post('verify-email', [AuthController::class, 'verifyEmail']);
});

//must verified
Route::middleware(['auth:sanctum', 'isVerified'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    // data master

    //update status sikoja
    Route::patch('updateStatus/{id}', [SikojaController::class, 'updateStatus']);
    //disposition sikoja
    Route::patch('sikojadisp/{id}', [SikojadispController::class, 'update']);
    Route::post('uploadFile', [FileController::class, 'uploadFiles']);
});

// must verified and just admin
Route::middleware(['auth:sanctum', 'isVerified', 'isAdmin'])->group(function () {
    Route::post('street', [StreetController::class, 'store']);
    Route::patch('street/{id}', [StreetController::class, 'update']);
    Route::delete('street/{id}', [StreetController::class, 'destroy']);
    Route::post('village', [VillageController::class, 'store']);
    Route::patch('village/{id}', [VillageController::class, 'update']);
    Route::delete('village/{id}', [VillageController::class, 'destroy']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('user', [AuthController::class, 'user']);
    Route::get('check-token', [AuthController::class, 'tokenCheck']);
    Route::post('category', [CategoryController::class, 'store']);
    Route::patch('category/{id}', [CategoryController::class, 'update']);
    Route::post('instance', [InstanceController::class, 'store']);
    Route::patch('instance', [InstanceController::class, 'update']);
    Route::get('status', [StatusController::class, 'index']);
    Route::post('status', [StatusController::class, 'store']);
    Route::patch('status', [StatusController::class, 'update']);
    Route::post('sikojadisp', [SikojadispController::class, 'store']);
});
