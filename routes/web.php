<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContentController;
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

/*
Route::get('/', function () {
    return view('welcome');
});
*/



Route::get('/login', function () {
    return view('login');
});
Route::post('login', [LoginController::class,'check'])->name('check');
Route::resource('companys', CompanyController::class);
Route::resource('contents', ContentController::class);
Route::view('/left', 'layouts.left')->name('left');

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Auth::routes();

Route::get('/', function() {
    return view('welcome');
});

Route::get('/{pathMatch}', function(){
    return view('welcome');
})->where('pathMatch',".*");