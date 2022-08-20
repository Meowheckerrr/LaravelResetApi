<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\authController;
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

//Route::resource('products', ProductController::class);

//public

//productController
Route::get('/products', [ProductController::class, "show"]);
Route::get('/products/{id}', [ProductController::class,'show']);
Route::get('/products/search/{name}', [ProductController::class,'search']);

//authCOntroller
Route::post('/register', [authController::class, "register"]);

//protect router
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    //productController
    Route::post('/products', [ProductController::class, "store"]);
    Route::put('/products/{id}', [ProductController::class, "update"]);
    Route::delete('/products/{id}', [ProductController::class, "destroy"]);
    
    //auttController 
    Route::post('/login', [authController::class, "login"]);
    Route::post('/logout', [authController::class, "logout"]);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 
