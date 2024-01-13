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

/* Authentication Route */

Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function () {
    Route::apiResource('/user', UserController::class);
    Route::apiResource('/service', ServiceController::class);

    /* Admin Route */
    Route::prefix('admin')->group(function () {
        Route::apiResource('/service-type', ServiceTypeController::class);
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
    Route::prefix('warga')->group(function () {
        Route::get('/mail', [MailController::class, 'indexMailUser']);
        Route::post('/mail/{mail}', [MailController::class, 'storeMailUser']);
        Route::get('/mail/{mail}', [MailController::class, 'showMailUser']);
        Route::patch('/mail/{mail}', [MailController::class, 'updateMailUser']);
        Route::delete('/mail/{mail}', [MailController::class, 'deleteMailUser']);
    });
});
