<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\APIcontroller;
use Illuminate\Support\Facades\Auth;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('/register', [APIcontroller::class,'store']);
Route::post('/login', [APIcontroller::class,'show']);
Route::get('/staff', [APIcontroller::class,'getstaff'])->middleware('auth:sanctum');
Route::get('/detail', [APIcontroller::class,'detail'])->middleware('auth:sanctum');
