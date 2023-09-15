<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

//Method get fetch data in db show
Route::get('products', [ProductController::class , 'index']); 

//Method post to insert data to db
Route::post('product', [ProductController::class, 'store']);

//Method Put to update data in db
//but in this have image can't use method put to update
//because method put can't get data from formdata 
//if use not has image can't use method put to update data in raw
Route::post('product/{id}', [ProductController::class, 'update']);

//Method delete to delete data in db
Route::delete('product/{id}', [ProductController::class, 'destroy']);








//check connection db with mysql
use Illuminate\Support\Facades\DB;
Route::get('/check-db-connection', function(){
   try {
    DB::connection()->getPdo();
    echo "Connected Successfully to: ".DB::connection()->getDatabaseName();

   } catch (\Exception $e) {
    die("Could not connect to database, Please check your Configuration. error:".$e);
   }
});