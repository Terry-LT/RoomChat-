<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ChatMessage\ChatMessageController;
use App\Http\Controllers\Api\Room\RoomController;
use App\Models\ChatMessage;

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


//Auth
Route::post('register/',[RegisterController::class,'store']);
Route::post('login/',[LoginController::class,'store']);
Route::post('logout/',[LogoutController::class,'store'])->middleware('auth:sanctum');

//Room Urls
Route::get('rooms/',[RoomController::class,'index']);
Route::group(['prefix' => 'rooms','middleware' => 'auth:sanctum'],function() {
    Route::post('/',[RoomController::class,'show']);
    Route::post('/random',[RoomController::class,'store']);
}
);

//Chat Message Urls
Route::group(['prefix' => 'messages','middleware' => 'auth:sanctum'],function() {
    Route::post('/',[ChatMessageController::class,'store']);
    Route::get('/',[ChatMessageController::class,'index']);
    Route::delete('/{message_id}',[ChatMessageController::class,'destroy']);
    Route::patch('/{message_id}',[ChatMessageController::class,'update']);
}
);
