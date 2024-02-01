<?php

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

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContentController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_all_companies', [CompanyController::class,'get_all_companies']);
Route::get('/get_all_companies_index', [CompanyController::class,'get_all_companies_index']);
Route::get('/search_companies', [CompanyController::class,'search_companies']);
Route::get('/create_company', [CompanyController::class,'create_company']);
Route::get('/show_companyForEdit/{id}', [CompanyController::class,'show_companyForEdit']);
Route::get('/show_companyOrder/{id}', [CompanyController::class,'show_companyOrder']);
Route::get('/show_companyOrder_limit', [CompanyController::class,'show_companyOrder_limit']);
Route::post('/add_company', [CompanyController::class,'add_company']);
Route::post('/edit_company/{id}', [CompanyController::class,'edit_company']);

Route::get('/delete_companyOrder/{id}', [ContentController::class,'delete_order']);
Route::post('/add_content', [ContentController::class,'add_content']);

Route::get('/get_all_products', [ProductController::class,'get_all_products']);
