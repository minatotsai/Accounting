<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CompanyController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::post('login', [LoginController::class,'passAuth']);
Route::get('companyList', [CompanyController::class,'index']);


Route::view('/login', 'login')->name('login');
Route::view('/left', 'layouts.left')->name('left');
Route::view('/main', 'main')->name('main');