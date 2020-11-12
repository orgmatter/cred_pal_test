<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\AuthController;
use App\Http\Controllers\Users\DashboardController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register/{ref_code?}', [AuthController::class, 'register']);

Route::middleware('jwt.auth')->group(function() {
    
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::put('/dashboard/reset_password', [DashboardController::class, 'reset_password']);
    Route::post('/dashboard/upload_document', function(Request $request) {
        // return $request->file('identity');
        return response()->JSON(['msg' => $request->file('identity')]);
    });
    Route::post('/dashboard/wallet/spend', [DashboardController::class, 'user_wallet_spend']);
    Route::put('/dashboard/wallet/save', [DashboardController::class, 'user_wallet_save']);
});
