<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\AuthController;


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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});

Route::post('/quiz/{id}/publish', [QuizController::class, 'publish']);
Route::post('/quiz/{id}/unpublish', [QuizController::class, 'unpublish']);
// Route::get('/user/{id}', [ScoreController::class, 'user']);

Route::apiResource('/quiz', QuizController::class);
// Route::apiResource('/quiz/{id}/publish', QuizController::class);
// Route::apiResource('/quiz/unpublish', QuizController::class);
Route::apiResource('/quiz/{id}/questions', QuestionController::class);
Route::apiResource('/question/{id}/choices', ChoiceController::class);
Route::apiResource('/score', ScoreController::class);
Route::apiResource('/user', ScoreController::class);

