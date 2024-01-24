<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\MailController;
use App\Http\Controllers\Api\ServiceTypeController;

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

/* Unauthenticated Route */
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::get('/services', [ServiceController::class, 'index']);

Route::middleware('auth:api')->group(function () {
    /* Authenticated Route */
    Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

    /* Global User Route */
    Route::post('/user', [UserController::class, 'store']);
    Route::get('/user/{user}', [UserController::class, 'show']);
    Route::patch('/user/{user}', [UserController::class, 'update']);

    /* Global Service Route */
    Route::get('/{service}', [ServiceController::class, 'show']);

    /* Admin Route */
    Route::prefix('admin')->middleware('role:KECAMATAN,DESA')->group(function () {
        /* User Route */
        Route::get('/users', [UserController::class, 'index']);
        Route::delete('/user/{user}', [UserController::class, 'destroy']);

        /* Service Route */
        Route::post('/service', [ServiceController::class, 'store']);
        Route::patch('/service/{service}', [ServiceController::class, 'update']);
        Route::delete('/service/{service}', [ServiceController::class, 'destroy']);
        Route::apiResource('/service/service-type', ServiceTypeController::class);

        /* Mail Route */
        Route::get('/mail', [MailController::class, 'indexMailAdmin']);
        Route::post('/mail', [MailController::class, 'storeMailAdmin']);
        Route::get('/mail/submissions', [MailController::class, 'indexMailSubmission']);
        Route::get('/mail/{mail}', [MailController::class, 'showMailAdmin']);
        Route::get('/mail/{mail}/recap', [MailController::class, 'recapMailAdmin']);
        Route::patch('/mail/{mail}', [MailController::class, 'updateMailAdmin']);
        Route::delete('/mail/{mail}', [MailController::class, 'destroy']);
        Route::patch('/mail/{mail}/approval', [MailController::class, 'approval']);
        Route::delete('/mail/{mail}', [MailController::class, 'deleteMailAdmin']);
    });

    /* Warga Route */
    Route::prefix('warga')->middleware(['role:WARGA'])->group(function () {
        /* Mail Route */
        Route::get('/mail', [MailController::class, 'indexMailUser']);
        Route::post('/mail/{mail}', [MailController::class, 'storeMailUser']);
        Route::get('/mail/{mail}', [MailController::class, 'showMailUser']);
        Route::patch('/mail/{mail}', [MailController::class, 'updateMailUser']);
        Route::delete('/mail/{mail}', [MailController::class, 'deleteMailUser']);
    });
});
