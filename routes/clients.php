<?php

use App\Http\Controllers\Api\ConsultingMessagesController;
use App\Http\Controllers\Client\ChatController;
use App\Http\Controllers\Client\ConsultingController;
use App\Http\Controllers\Client\OfferController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\RefundController;
use App\Http\Controllers\Client\SpecialServiceController;
use App\Http\Controllers\Client\VendorController;
use App\Http\Controllers\Front\ContractController;
use App\Http\Controllers\Front\DocumentController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\InvoiceController;
use App\Http\Controllers\Front\NegotiationController;
use App\Http\Controllers\Front\JudgerOrderController;
use App\Http\Controllers\Front\ObjectionController;
use App\Http\Controllers\Front\ObjectionTalkController;
use App\Http\Controllers\Front\OrderDecryptionRequests;
use App\Http\Controllers\Front\OrderDocumentController;
use App\Http\Controllers\Front\PayWithTapController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth'], function () {
    /* ============== Profile ============== */
    Route::get('/', [ProfileController::class, 'profile'])->name('profile');
    Route::get('settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('settings', [ProfileController::class, 'updateSettings'])->name('settings.update');

    /* ============== Documents ============== */
    Route::group(['middleware' => 'user_is_delete'], function () {
        Route::get('documents', [DocumentController::class, 'documents'])->name('documents');
        Route::post('license', [DocumentController::class, 'license'])->name('license');
        Route::post('commercial', [DocumentController::class, 'commercial'])->name('commercial');
        Route::post('company-info', [DocumentController::class, 'companyInfo'])->name('company.info');
        /* ==============*** Search About Vendor ============== */
        Route::get('vendors', [VendorController::class, 'vendors'])->name('allVendors');
        Route::get('vendor/{id}/profile', [VendorController::class, 'vendorShow'])->name('vendor.profile');
        /* ============== Invoices ============== */
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('invoices/{invoice}/show', [InvoiceController::class, 'show'])->name('invoices.show');
        /* ============= Special Services ============= */
        Route::resource('specialServices', SpecialServiceController::class);
        Route::post('specialServices/{specialService}/msg', [SpecialServiceController::class, 'storeMessage'])->name('specialServices.msg');
        /* ==============**** Orders And Offers ============== */
        Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::put('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update_status');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{hash_code}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
        Route::get('orders/{order}/vendors/{vendor}/offers', [OfferController::class, 'vendorOffers'])->name('orders.vendor_offers');
        Route::put('offers/{offer}', [OfferController::class, 'update'])->name('offer.update');
        Route::get('orders/{hash_code}/logs', [OrderController::class, 'logs'])->name('orders.log');
        /* ============== Negotiation ============== */
        Route::get('orders/{order}/negotiations/{negotiation}', [NegotiationController::class, 'show'])->name('negotiations.show');
        Route::post('negotiations/{negotiation}/message', [NegotiationController::class, 'storeMessage'])->name('storeMessage');
        /* ============== JudgerOrder ============== */
        Route::put('select-judgers/', [JudgerOrderController::class, 'clientDecision'])->name('selectedJudgers.clientDecision');
        /* ============== Contract ============== */
        Route::get('orders/{hash_code}/contract', [ContractController::class, 'show'])->name('contracts.show');
        Route::post('orders/{order}/before-accept-contract', [ContractController::class, 'clientBeforeAccept'])->name('contract.before-accept');
        Route::post('orders/{order}/contract', [ContractController::class, 'clientAccept'])->name('contract.client_accept');
        /* ============== Order Invoices ============== */
        Route::get('orders/{hash_code}/invoices', [InvoiceController::class, 'orderInvoices'])->name('invoices.orderInvoices');
        /* ==============** Pay With Tap ============== */
        /* Route::post('invoices/{invoice}', [PayWithTapController::class, 'payment'])->name('invoices.payment');
    Route::any('tap-callback/{order}/{invoice}', [PayWithTapController::class, 'callbackOrders'])->name('tap.callback'); */
        /* ==============******* Events ============== */
        Route::get('orders/{hash_code}/events', [EventController::class, 'index'])->name('events');
        Route::get('orders/{hash_code}/events/{event}', [EventController::class, 'show'])->name('events.show');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
        /* ==============***** Documents ============== */
        Route::get('orders/{hash_code}/documents', [OrderDocumentController::class, 'index'])->name('documents');
        Route::post('documents', [OrderDocumentController::class, 'store'])->name('documents.store');
        /* ==============***** Objection ============== */
        Route::get('orders/{hash_code}/objection', [ObjectionController::class, 'index'])->name('objection');
        Route::post('objections', [ObjectionController::class, 'store'])->name('objection.store');
        Route::put('objections/{objection}/seen', [ObjectionController::class, 'seen'])->name('objection.seen');
        Route::put('objections/{objection}/decision', [ObjectionController::class, 'client_decision'])->name('objection.decision');
        Route::post('objection-talks', [ObjectionTalkController::class, 'store'])->name('objection_talks.store');
        Route::post('objection-judgment', [ObjectionController::class, 'objectionJudgment'])->name('objection.judgment');
        /* ************************** decryptionRequests ============== */
        Route::get('orders/{hash_code}/decryption-requests', [OrderDecryptionRequests::class, 'index'])->name('decryption_request.index');
        Route::put('decryption-requests/{order}/{vendor}', [OrderDecryptionRequests::class, 'update'])->name('decryption_request.update');
        /* ==============******* Refund ============== */
        Route::post('refund', [RefundController::class, 'store'])->name('refund.store');
        Route::post('accept-offer', [RefundController::class, 'store'])->name('refund.store');
        /* ==============**** Consulting ============== */
        Route::resource('consulting', ConsultingController::class);
        Route::post('consulting/accept-offer', [ConsultingController::class, 'acceptOffer'])->name('consulting.accept.offer');
        Route::any('consulting-callback/{invoice}', [ConsultingController::class, 'callback'])->name('consulting.callback');
        Route::post('consulting/evaluate', [ConsultingController::class, 'evaluate'])->name('consulting.evaluate');
    });
});
