<?php

use App\Http\Controllers\Api\General\ConsultingController;
use App\Http\Controllers\Api\General\OrderController;
use App\Http\Controllers\Api\General\UserController;
use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');


Route::get('all_users/{id_number}', [UserController::class, 'index']);
Route::get('all_users/client/{id_number}', [UserController::class, 'client']);
Route::get('all_users/vendor/{id_number}', [UserController::class, 'vendor']);
Route::get('all_users/judger/{id_number}', [UserController::class, 'judger']);
Route::get('orders', [OrderController::class, 'index']);
Route::get('consulting', [ConsultingController::class, 'index']);
Route::get('clientSearch', [UserController::class, 'clientSearch']);
Route::get('vendorSearch', [UserController::class, 'vendorSearch']);
