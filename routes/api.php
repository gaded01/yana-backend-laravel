<?php

use App\Http\Controllers\ElderlyAbuseTestController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [UserController::class, 'signupUser']);


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/test-item', [ElderlyAbuseTestController::class, 'countTestAnswer']);

    Route::post('/get-test-question/{id}', [ElderlyAbuseTestController::class, 'getTestQuestion']);
    Route::get('/get-test-option', [ElderlyAbuseTestController::class, 'getTestOption']);
    Route::post('/test-answer', [ElderlyAbuseTestController::class, 'testAnswer']);
    Route::get('/test-result', [ElderlyAbuseTestController::class, 'testResult']);
    
    Route::post('/check-test', [UserController::class, 'checkLastTest']);
    
    Route::post('/beck_result-email', [MailController::class, 'beckResultEmail']);
    Route::post('/usdi_result-email', [MailController::class, 'usdiResultEmail']);

    Route::post('/user-logout', [UserController::class, 'signoutUser']); 
});

