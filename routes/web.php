<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('CheckLogout')->group(function(){

//out app
Route::get('/login', [Main::class, 'login'])->name('login');
Route::post('/login_submit', [Main::class, 'login_submit'])->name('login_submit');
});


//in app
Route::middleware('CheckLogin')->group(function(){
    
    Route::get('/', [Main::class, 'index'])->name('index');    
    Route::get('/logout', [Main::class, 'logout'])->name('logout');

});

