<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PettyCashController;
use App\Http\Controllers\ImprestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });


Route::get('/', [PettyCashController::class,'index']);
Route::post('pettycash/store', [PettyCashController::class,'store']);
Route::get('delete/{id}', [PettyCashController::class,'delete']);

Route::post('imprest/store', [ImprestController::class,'store']);

Route::get('db/clear', [PettyCashController::class,'deleteDB']);



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', [PettyCashController::class,'index'])->name('dashboard');
});
