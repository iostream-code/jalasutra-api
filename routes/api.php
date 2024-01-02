<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\MailController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/user', UserController::class);
Route::apiResource('/service', ServiceController::class);

/* Admin Route */
Route::prefix('admin')->group(function () {
    Route::get('/mail', [MailController::class, 'index']);
    Route::post('/mail', [MailController::class, 'store']);
    Route::get('/mail/submissions', [MailController::class, 'indexMailSubmission']);
    Route::get('/mail/{mail}', [MailController::class, 'show']);
    Route::patch('/mail/{mail}', [MailController::class, 'updateMailAdmin']);
    Route::delete('/mail/{mail}', [MailController::class, 'destroy']);
    Route::patch('/mail/{mail}/approval', [MailController::class, 'approval']);
});

/* Warga Route */
Route::prefix('warga')->group(function () {
    Route::post('/mail/{mail}', [MailController::class, 'storeUserMail']);
    Route::patch('/mail/{mail}', [MailController::class, 'updateMailUser']);
});
