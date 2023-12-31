<?php

use App\Http\Controllers\Api\MailController;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserProfileController;

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
Route::get('api/mail', [MailController::class, 'index']);
Route::post('api/mail', [MailController::class, 'store']);
Route::get('api/mail/{mail}', [MailController::class, 'show']);
Route::patch('api/mail/a/{mail}', [MailController::class, 'updateForAdmin']);
Route::patch('api/mail/u/{mail}', [MailController::class, 'updateForUser']);
Route::delete('api/mail{mail}', [MailController::class, 'destroy']);
