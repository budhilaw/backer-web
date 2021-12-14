<?php

use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CampaignController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::apiResource('campaign', \App\Http\Controllers\Api\CampaignController::class);

Route::prefix('campaign')->group(function() {
    Route::get('/', [CampaignController::class, 'index']);
    Route::get('/{campaign:slug}', [CampaignController::class, 'show']);
    Route::post('/store', [CampaignController::class, 'store']);
    Route::post('/update', [CampaignController::class, 'update']);
    Route::delete('/destroy/{id}', [CampaignController::class, 'destroy']);
    Route::post('/uploadCampaignImage', [CampaignController::class, 'uploadImageCampaign']);
});

Route::prefix('transaction')->group(function() {
    Route::get('/', [TransactionController::class, 'index']);
    Route::get('/{transaction:id}', [TransactionController::class, 'show']);
    Route::post('/store', [TransactionController::class, 'store']);
    Route::post('/update', [TransactionController::class, 'update']);
    Route::delete('/destroy/{id}', [TransactionController::class, 'destroy']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'user'], function() {
    Route::get('/', [AuthController::class, 'userProfile']);
    Route::put('/edit/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('/avatar', [UserController::class, 'avatar'])->name('user.avatar');
    Route::get('/campaigns', [UserController::class, 'campaigns'])->name('user.campaigns');
});

// https://backer.test/api/auth/register
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function() {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

