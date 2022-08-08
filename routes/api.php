<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Master\StatusController;
use App\Http\Controllers\Master\StreetController;
use App\Http\Controllers\Sikoja\GaleryController;
use App\Http\Controllers\Sikoja\SikojaController;
use App\Http\Controllers\Master\VillageController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\InstanceController;
use App\Http\Controllers\Sibolang\SibolangController;
use App\Http\Controllers\Sibolang\SibolangdispController;
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

//Auth
Route::post('login', [AuthController::class, 'login']);

//sikoja
Route::get('sikoja', [SikojaController::class, 'index']);
Route::get('sikoja/{id}', [SikojaController::class, 'show']);
Route::post('sikoja', [SikojaController::class, 'store']);

//sikojadip
Route::get('sikojadisp', [SikojadispController::class, 'index']);
Route::get('sikojadisp/{id}', [SikojadispController::class, 'show']);

//sibolang
Route::get('sibolang', [SibolangController::class, 'index']);
Route::get('sibolang/{id}', [SibolangController::class, 'show']);
Route::post('sibolang', [SibolangController::class, 'store']);

//sibolangdisp
Route::get('sibolangdisp', [SibolangdispController::class, 'index']);
Route::get('sibolangdisp/{id}', [SibolangdispController::class, 'show']);

//upload
Route::post('uploadGalery', [GaleryController::class, 'uploadGaleries']); // upload galery untuk data sikoja
Route::post('uploadGalerySibolang', [SibolangController::class, 'uploadGaleries']); //upload galery untuk data sibolang
Route::post('uploadStreet', [ImportController::class, 'streetImport']); // import data untuk data jalan
Route::post('uploadVillage', [ImportController::class, 'villageImport']); //import data untuk data kampung

//master get all data
Route::get('category', [CategoryController::class, 'index']);
Route::get('instance', [InstanceController::class, 'index']);
Route::get('street', [StreetController::class, 'index']);
Route::get('village', [VillageController::class, 'index']);




Route::middleware('auth:sanctum')->group(function () {
    Route::post('resend-verify-email', [AuthController::class, 'resendEmailVerification']);
    Route::post('verify-email', [AuthController::class, 'verifyEmail']);
});

//must verified
Route::middleware(['auth:sanctum', 'isVerified'])->group(function () {
    //user
    Route::post('logout', [AuthController::class, 'logout']);
    Route::patch('user/{id}', [AuthController::class, 'updateProfile']);

    //update status sikoja
    Route::patch('updateStatus/{id}', [SikojaController::class, 'updateStatus']);

    //disposition sikoja
    Route::patch('sikojadisp/{id}', [SikojadispController::class, 'update']);
    Route::post('uploadFile', [FileController::class, 'uploadFiles']);

    //update status sibolang
    Route::patch('updateStatusSibolang/{id}', [SibolangController::class, 'updateStatus']);

    //disposition sikoja
    Route::patch('sibolangdisp/{id}', [SibolangdispController::class, 'update']);
    Route::post('uploadFileSibolangdisp', [SibolangdispController::class, 'uploadFiles']);
});

// must verified and just admin
Route::middleware(['auth:sanctum', 'isVerified', 'isAdmin'])->group(function () {
    //user
    Route::post('register', [AuthController::class, 'register']);
    Route::get('user', [AuthController::class, 'user']);
    Route::delete('user/{id}', [AuthController::class, 'destroy']);
    // Route::get('check-token', [AuthController::class, 'tokenCheck']);

    //street
    Route::post('street', [StreetController::class, 'store']);
    Route::patch('street/{id}', [StreetController::class, 'update']);
    Route::delete('street/{id}', [StreetController::class, 'destroy']);

    //village
    Route::post('village', [VillageController::class, 'store']);
    Route::patch('village/{id}', [VillageController::class, 'update']);
    Route::delete('village/{id}', [VillageController::class, 'destroy']);

    //category
    Route::post('category', [CategoryController::class, 'store']);
    Route::patch('category/{id}', [CategoryController::class, 'update']);

    //instance
    Route::post('instance', [InstanceController::class, 'store']);
    Route::patch('instance/{id}', [InstanceController::class, 'update']);

    //status
    Route::get('status', [StatusController::class, 'index']);
    // Route::post('status', [StatusController::class, 'store']);
    Route::patch('status/{id}', [StatusController::class, 'update']);

    //sikojadisp
    Route::post('sikojadisp', [SikojadispController::class, 'store']);

    //sibolangdisp
    Route::post('sibolangdisp', [SibolangdispController::class, 'store']);
});
