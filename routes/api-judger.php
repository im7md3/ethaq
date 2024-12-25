<?php

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

use App\Http\Controllers\Api\Front\ContactUsController;
use App\Http\Controllers\Api\Front\EventController;
use App\Http\Controllers\Api\Front\InvoiceController;
use App\Http\Controllers\Api\Front\JudgerOrderController;
use App\Http\Controllers\Api\Front\ObjectionController;
use App\Http\Controllers\Api\Front\ObjectionTalkController;
use App\Http\Controllers\Api\Front\OrderDocumentController;
use App\Http\Controllers\Api\Judger\OrderController;
use App\Http\Controllers\Api\Judger\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {
    /* ============== Profile ============== */
    Route::get('settings', [ProfileController::class, 'settings'])->name('settings')->middleware('auth:sanctum');
    Route::post('settings', [ProfileController::class, 'updateSettings'])->name('settings.update');
    /* ============== Orders ============== */
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{hash_code}/logs', [OrderController::class, 'logs']);
    /* *********************************** Order Documents ****************************** */
    Route::get('orders/{hash_code}/documents', [OrderDocumentController::class, 'index']);
    /* ***************************************** JudgerOrder ****************************** */
    Route::put('select-judgers/', [JudgerOrderController::class, 'judgerDecision']);
    /* ************************************* Events ****************************** */
    Route::get('orders/{hash_code}/events', [EventController::class, 'index'])->name('events');
    Route::get('orders/{hash_code}/events/{event}', [EventController::class, 'show'])->name('events.show');
    /* ***************************************** Order Invoices ****************************** */
    Route::get('orders/{hash_code}/invoices', [InvoiceController::class, 'orderInvoices'])->name('invoices.orderInvoices');
    /* ***************************************** Objection ****************************** */
    Route::get('orders/{hash_code}/objection', [ObjectionController::class, 'index']);
    Route::put('objections/{objection}/time', [ObjectionController::class, 'time']);
    Route::get('orders/{hash_code}/arbitration', [ObjectionController::class, 'arbitration']);
    Route::put('orders/{order}/arbitration', [ObjectionController::class, 'arbitrationStore']);
    Route::post('objection-talks', [ObjectionTalkController::class, 'store']);
});

Route::post('contact-us/store', [ContactUsController::class, 'store']);
