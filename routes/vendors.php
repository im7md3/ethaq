<?php

use App\Http\Controllers\Front\ContractController;
use App\Http\Controllers\Front\DocumentController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\InvoiceController;
use App\Http\Controllers\Front\NegotiationController;
use App\Http\Controllers\Vendor\ProfileController;
use App\Http\Controllers\Vendor\HomeController;
use App\Http\Controllers\Front\JudgerOrderController;
use App\Http\Controllers\Front\ObjectionController;
use App\Http\Controllers\Front\ObjectionTalkController;
use App\Http\Controllers\Front\OrderDecryptionRequests;
use App\Http\Controllers\Front\OrderDocumentController;
use App\Http\Controllers\Front\PayWithTapController;
use App\Http\Controllers\Vendor\ChatController;
use App\Http\Controllers\Vendor\ConsultingController;
use App\Http\Controllers\Vendor\ConsultingOffersController;
use App\Http\Controllers\Vendor\OfferController;
use App\Http\Controllers\Vendor\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    /* ***************************************** Home ****************************** */
    Route::get('/orders', [HomeController::class, 'orders'])->name('home');
    /* ***************************************** Profile ****************************** */
    Route::get('settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('settings', [ProfileController::class, 'updateSettings'])->name('settings.update');

    /* ***************************************** Documents ****************************** */
    Route::get('documents', [DocumentController::class, 'documents'])->name('documents');
    Route::post('license', [DocumentController::class, 'license'])->name('license');
    Route::post('advisorFiles', [DocumentController::class, 'advisorFiles'])->name('advisorFiles');
    Route::put('license/{license}', [DocumentController::class, 'licenseUpdate'])->name('license.update');
    Route::post('commercial', [DocumentController::class, 'commercial'])->name('commercial');
    Route::post('company-info', [DocumentController::class, 'companyInfo'])->name('company.info');
    /* ***************************************** Invoices ****************************** */
    Route::group(['middleware' => 'user_is_delete'], function () {

        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('invoices/{invoice}/show', [InvoiceController::class, 'show'])->name('invoices.show');

        /* ***************************************** Orders & Offers ****************************** */
        Route::get('orders/{hash_code}', [OrderController::class, 'show'])->name('orders.show')->middleware('VendorShowOrder');
        Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
        Route::post('order-access/{hash_code}', [OrderController::class, 'orderAccess'])->name('orders.orderAccess')->middleware('VendorShowOrder');
        Route::put('orders/{order}/submission-of-work', [OrderController::class, 'submissionOfWork'])->name('orders.submissionOfWork');
        Route::post('offers', [OfferController::class, 'store'])->name('offers.store');
        Route::get('orders/{hash_code}/logs', [OrderController::class, 'logs'])->name('orders.log')->middleware('VendorShowOrder');
        /* ***************************************** Negotiation ****************************** */
        Route::post('negotiations/{negotiation}/message', [NegotiationController::class, 'storeMessage'])->name('storeMessage');
        Route::get('orders/{order}/negotiations/{negotiation}', [NegotiationController::class, 'show'])->name('negotiations.show');
        /* ***************************************** JudgerOrder ****************************** */
        Route::get('orders/{order}/select-judgers', [JudgerOrderController::class, 'create'])->name('selectJudgers');
        Route::post('select-judgers', [JudgerOrderController::class, 'store'])->name('selectJudgers.store');
        Route::post('without-judgers/{order}', [JudgerOrderController::class, 'withoutJudgers'])->name('without_judgers');
        /* ***************************************** Contract ****************************** */
        Route::get('orders/{hash_code}/contract', [ContractController::class, 'show'])->name('contracts.show')->middleware('VendorShowOrder');
        Route::post('orders/{order}/contract', [ContractController::class, 'vendorAccept'])->name('contract.vendor_accept');
        /* ***************************************** Order Invoices ****************************** */
        Route::get('orders/{hash_code}/invoices', [InvoiceController::class, 'orderInvoices'])->name('invoices.orderInvoices')->middleware('VendorShowOrder');

        /* ***************************************** Events ****************************** */
        Route::get('orders/{hash_code}/events', [EventController::class, 'index'])->name('events')->middleware('VendorShowOrder');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::get('orders/{hash_code}/events/{event}', [EventController::class, 'show'])->name('events.show')->middleware('VendorShowOrder');

        /* *********************************** Documents ****************************** */
        Route::get('orders/{hash_code}/documents', [OrderDocumentController::class, 'index'])->name('documents')->middleware('VendorShowOrder');
        Route::post('documents', [OrderDocumentController::class, 'store'])->name('documents.store');
        /* ***************************************** Objection ****************************** */
        Route::get('orders/{hash_code}/objection', [ObjectionController::class, 'index'])->name('objection')->middleware('VendorShowOrder');
        Route::post('objections', [ObjectionController::class, 'store'])->name('objection.store');
        Route::put('objections/{objection}/seen', [ObjectionController::class, 'seen'])->name('objection.seen');
        Route::put('objections/{objection}/decision', [ObjectionController::class, 'vendor_decision'])->name('objection.decision');
        Route::post('objection-talks', [ObjectionTalkController::class, 'store'])->name('objection_talks.store');
        Route::post('objection-judgment', [ObjectionController::class, 'objectionJudgment'])->name('objection.judgment');
        /* ***************************************** Favorite ****************************** */
        Route::post('favorite/{order}', [OrderController::class, 'favorite'])->name('favorite');
        /* ***************************************** decryptionRequests ****************************** */
        Route::post('decryption-requests/{order}', [OrderDecryptionRequests::class, 'store'])->name('decryption_request.store');
        Route::put('decryption-requests/{order}/login', [OrderDecryptionRequests::class, 'login'])->name('decryption_request.login');
        /* ***************************************** Pay With Tap ****************************** */
        /* Route::post('invoices/{invoice}', [PayWithTapController::class, 'payment'])->name('invoices.payment');
    Route::any('tap-callback/{order}/{invoice}', [PayWithTapController::class, 'callbackOrders'])->name('tap.callback'); */
        /* ************************ Routes with user_is_active middleware ************************* */
        Route::group(['middleware' => 'user_is_active'], function () {
            /* ************************************** Access Consulting ****************************** */
            Route::post('consulting-access', [ConsultingController::class, 'consultingAccess'])->name('consulting.Access');
            /* ************************************** Consulting ****************************** */
            Route::resource('consulting', ConsultingController::class);
            /* ******************************** Consulting Offers ****************************** */
            Route::post('consulting-offers', [ConsultingOffersController::class, 'store'])->name('consulting.offers.store');
            /* ********************************** Chat ****************************** */
            Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
        });
    });
});
