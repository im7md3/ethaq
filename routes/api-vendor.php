<?php

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

use App\Http\Controllers\Api\Front\ConsultingController as FrontConsultingController;
use App\Http\Controllers\Api\Front\ContactUsController;
use App\Http\Controllers\Api\Front\ContractController;
use App\Http\Controllers\Api\Front\DocumentController;
use App\Http\Controllers\Api\Front\EventController;
use App\Http\Controllers\Api\Front\InvoiceController;
use App\Http\Controllers\Api\Front\JudgerOrderController;
use App\Http\Controllers\Api\Front\ObjectionController;
use App\Http\Controllers\Api\Front\ObjectionTalkController;
use App\Http\Controllers\Api\Front\OrderDecryptionRequests;
use App\Http\Controllers\Api\Front\OrderDocumentController;
use App\Http\Controllers\Api\Front\OrderProtestController;
use App\Http\Controllers\Api\Vendor\ConsultingController;
use App\Http\Controllers\Api\Vendor\ConsultingOffersController;
use App\Http\Controllers\Api\Vendor\MainScreenController;
use App\Http\Controllers\Api\Vendor\OfferController;
use App\Http\Controllers\Api\Vendor\OrderController;
use App\Http\Controllers\Api\Vendor\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    /* ============== Profile ============== */
    Route::get('settings', [ProfileController::class, 'settings'])->name('settings');
    Route::post('settings', [ProfileController::class, 'updateSettings']);
    Route::post('update-info', [ProfileController::class, 'updateInfo']);
    Route::post('update-departments', [ProfileController::class, 'updateDepartments']);
    Route::post('update-consulting', [ProfileController::class, 'updateConsultingDepartment']);
    Route::post('update-financial', [ProfileController::class, 'updateFinancial']);
    Route::get('times', [ProfileController::class, 'times']);
    Route::post('update-times', [ProfileController::class, 'updateTimes']);
    /* ============== Main Screen ============== */
    Route::get('main-screen', [MainScreenController::class, 'mainScreen']);
    /* ============== Orders ============== */
    Route::group(['middleware' => 'user_is_delete_api'], function () {
        Route::get('orders', [OrderController::class, 'orders']);
        /* ============== Consulting ============== */
        Route::get('consulting', [ConsultingController::class, 'index']);
        Route::post('consulting/{consulting}/cancel', [FrontConsultingController::class, 'cancel']);
        /* ============ Routes with user_is_active middleware ============* */
        Route::group(['middleware' => 'user_is_active_api'], function () {
            Route::get('private-orders', [OrderController::class, 'private']);
            Route::get('orders/{hash_code}', [OrderController::class, 'show'])->middleware('VendorShowOrderApi');
            Route::post('orders/{order}/cancel', [OrderController::class, 'cancel']);
            Route::post('order-access/{hash_code}', [OrderController::class, 'orderAccess'])->middleware('VendorShowOrderApi');
            Route::post('offers', [OfferController::class, 'store']);
            Route::post('orders/{order}/submission-of-work', [OrderController::class, 'submissionOfWork']);
            Route::get('orders/{hash_code}/logs', [OrderController::class, 'logs'])->middleware('VendorShowOrderApi');
            /* ============== Order Documents ============== */
            Route::get('orders/{hash_code}/documents', [OrderDocumentController::class, 'index'])->middleware('VendorShowOrderApi');
            Route::post('documents', [OrderDocumentController::class, 'store']);
            /* ============== decryptionRequests ============== */
            Route::post('decryption-requests/{order}', [OrderDecryptionRequests::class, 'store']);
            Route::post('decryption-requests/{order}/login', [OrderDecryptionRequests::class, 'login']);
            /* ============== JudgerOrder ============== */
            Route::get('orders/{order}/select-judgers', [JudgerOrderController::class, 'create']);
            Route::post('select-judgers', [JudgerOrderController::class, 'store']);
            Route::post('without-judgers/{order}', [JudgerOrderController::class, 'withoutJudgers']);
            /* ============== Contract ============== */
            Route::get('orders/{hash_code}/contract', [ContractController::class, 'show'])->middleware('VendorShowOrderApi');
            Route::get('orders/{order}/contract/download', [ContractController::class, 'download'])->middleware('VendorShowOrderApi');
            Route::post('orders/{order}/contract', [ContractController::class, 'vendorAccept']);
            /* ============== Events ============== */
            Route::get('orders/{hash_code}/events', [EventController::class, 'index'])->middleware('VendorShowOrderApi');
            Route::get('orders/{hash_code}/events/{event}', [EventController::class, 'show'])->middleware('VendorShowOrderApi');
            Route::post('events', [EventController::class, 'store']);
            Route::put('events/{event}', [EventController::class, 'update']);
            /* ============== Protests ============== */
            Route::get('orders/{hash_code}/protests', [OrderProtestController::class, 'index'])->middleware('VendorShowOrderApi');
            Route::post('protests', [OrderProtestController::class, 'store']);
            /* ============== Order Invoices ============== */
            Route::get('orders/{hash_code}/invoices', [InvoiceController::class, 'orderInvoices'])->middleware('VendorShowOrderApi');
            /* ============********** Objection ============ */
            Route::get('objections/{objection}', [ObjectionController::class, 'show']);
            Route::post('objections', [ObjectionController::class, 'store']);
            Route::put('objections/{objection}/seen', [ObjectionController::class, 'seen']);
            Route::post('objections/{objection}/decision', [ObjectionController::class, 'vendor_decision']);
            Route::post('objection-talks', [ObjectionTalkController::class, 'store']);
            Route::post('objection-judgment', [ObjectionController::class, 'objectionJudgment']);
            /* ============******* Consulting ============ */
            Route::resource('consulting', ConsultingController::class);
            /* ============******* Access Consulting ============ */
            Route::post('consulting-access', [ConsultingController::class, 'consultingAccess']);
            /* ============* Consulting Offers ============ */
            Route::post('consulting-offers', [ConsultingOffersController::class, 'store']);
        });
    });

    Route::post('contact-us/store', [ContactUsController::class, 'store']);
});
