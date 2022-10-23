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
Route::post('/login', [UserController::class, 'loginUser']);


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/test-item', [ElderlyAbuseTestController::class, 'countTestAnswer']);

    Route::post('/register-elder', [ElderlyAbuseTestController::class, 'addElderInfo']);

    Route::post('/get-test-question/{id}', [ElderlyAbuseTestController::class, 'getTestQuestion']);
    Route::get('/get-test-option', [ElderlyAbuseTestController::class, 'getTestOption']);
    Route::post('/remove-answer', [ElderlyAbuseTestController::class, 'removeAnswer']);
    Route::post('/test-answer', [ElderlyAbuseTestController::class, 'testAnswer']);

    Route::post('/print-pdf', [ElderlyAbuseTestController::class, 'printPdf']);

    Route::post('/test-result', [ElderlyAbuseTestController::class, 'testResult']);
    Route::post('/view-result', [ElderlyAbuseTestController::class, 'getTestAnswer']);
    
    Route::post('/check-test', [UserController::class, 'checkLastTest']);

    Route::post('/rate-elder', [ElderlyAbuseTestController::class, 'elderRate']);
    
    Route::post('/beck_result-email', [MailController::class, 'beckResultEmail']);
    Route::post('/usdi_result-email', [MailController::class, 'usdiResultEmail']);

    Route::post('/user-logout', [UserController::class, 'signoutUser']); 
});

