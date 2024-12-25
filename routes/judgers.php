<?php

use App\Http\Controllers\Front\ContractController;
use App\Http\Controllers\Front\DocumentController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\InvoiceController;
use App\Http\Controllers\Front\JudgerOrderController;
use App\Http\Controllers\Front\ObjectionController;
use App\Http\Controllers\Front\ObjectionTalkController;
use App\Http\Controllers\Front\OrderDocumentController;
use App\Http\Controllers\Judger\ProfileController;
use App\Http\Controllers\Judger\HomeController;
use App\Http\Controllers\Judger\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    /* ***************************************** Home ****************************** */
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    /* ***************************************** Profile ****************************** */
    Route::get('settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('settings', [ProfileController::class, 'updateSettings'])->name('settings.update');

    /* ***************************************** Documents ****************************** */
    Route::get('documents', [DocumentController::class, 'documents'])->name('documents');
    Route::post('license', [DocumentController::class, 'license'])->name('license');
    /* ***************************************** Orders ****************************** */
    Route::group(['middleware' => 'user_is_active'], function () {
        Route::get('orders/{hash_code}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{hash_code}/logs', [OrderController::class, 'logs'])->name('orders.log');
        /* ***************************************** JudgerOrder ****************************** */
        Route::put('select-judgers/', [JudgerOrderController::class, 'judgerDecision'])->name('selectedJudgers.judgerDecision');
        /* ***************************************** Contract ****************************** */
        Route::get('orders/{hash_code}/contract}', [ContractController::class, 'show'])->name('contracts.show');
        /* ***************************************** Invoices ****************************** */
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('orders/{hash_code}/invoices', [InvoiceController::class, 'orderInvoices'])->name('invoices.orderInvoices');
        Route::get('invoices/{invoice}/show', [InvoiceController::class, 'show'])->name('invoices.show');
        /* ***************************************** Events ****************************** */
        Route::get('orders/{hash_code}/events', [EventController::class, 'index'])->name('events');
        Route::get('orders/{hash_code}/events/{event}', [EventController::class, 'show'])->name('events.show');
        /* *********************************** Documents ****************************** */
        Route::get('orders/{hash_code}/documents', [OrderDocumentController::class, 'index'])->name('documents');
        /* ***************************************** Objection ****************************** */
        Route::get('orders/{hash_code}/objection', [ObjectionController::class, 'index'])->name('objection');
        Route::put('objections/{objection}/time', [ObjectionController::class, 'time'])->name('objection.time');
        Route::get('orders/{hash_code}/arbitration', [ObjectionController::class, 'arbitration'])->name('objection.sentencing');
        Route::put('orders/{order}/arbitration', [ObjectionController::class, 'arbitrationStore'])->name('objection.arbitration_store');
        Route::post('objection-talks', [ObjectionTalkController::class, 'store'])->name('objection_talks.store');
    });
});
