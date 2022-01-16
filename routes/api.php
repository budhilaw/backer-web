<?php

use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\AdminController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

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

Route::group(['middleware' => 'api', 'prefix' => 'campaign'], function () {
    Route::get('/', [CampaignController::class, 'index']);
    Route::get('/{campaign:slug}', [CampaignController::class, 'show']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'campaign'], function() {
    Route::post('/store', [CampaignController::class, 'store']);
    Route::post('/update/{id}', [CampaignController::class, 'update']);
    Route::delete('/destroy/{id}', [CampaignController::class, 'destroy']);
    Route::get('/image/list/{id}', [CampaignController::class, 'listImageCampaign']);
    Route::get('/image/primary/{id}', [CampaignController::class, 'setPrimaryImageCampaign']);
    Route::post('/image/upload/{id}', [CampaignController::class, 'uploadImageCampaign']);
    Route::delete('/image/destroy/{id}', [CampaignController::class, 'deleteImageCampaign']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'transaction'], function() {
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/store', [TransactionController::class, 'store']);
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'user'], function() {
    Route::get('/', [AuthController::class, 'userProfile']);
    Route::put('/edit/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/avatar', [UserController::class, 'avatar'])->name('user.avatar');
    Route::post('/edit/avatar/{id}', [UserController::class, 'uploadAvatar'])->name('user.upload.avatar');
    Route::get('/campaigns', [UserController::class, 'campaigns'])->name('user.campaigns');
});

// https://backer.test/api/auth/register
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function() {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::group(['middleware' => ['auth:api', 'adminOnly'], 'prefix' => 'admin'], function () {
    Route::get('/campaign/publish/{id}', [AdminController::class, 'publishCampaign']);
    Route::get('/transaction', [AdminController::class, 'listTransactions']);
    Route::get('/transaction/verify/{id}', [AdminController::class, 'verifyTransaction']);
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->stateless()->redirect();
});

Route::get('/auth/callback', function () {
    $user_google = Socialite::driver('google')->user();
    $user = User::where('email', $user_google->getEmail())->first();

    //jika user ada maka langsung di redirect ke halaman home
    //jika user tidak ada maka simpan ke database
    //$user_google menyimpan data google account seperti email, foto, dsb

    if ($user != null) {
        return response()->json(['user' => \auth()->login($user, true)]);
//        return redirect()->route('home');
    } else {
        $create = User::Create([
            'email' => $user_google->getEmail(),
            'name' => $user_google->getName(),
            'password' => 0,
            'email_verified_at' => now()
        ]);


        \auth()->login($create, true);
        return response()->json(['user' => \auth()->login($user, true)]);
    }
//        return redirect()->route('home');
});
