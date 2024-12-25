<?php

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

use App\Http\Controllers\Api\Client\ProfileController;
use App\Http\Controllers\Api\Client\ConsultingController;
use App\Http\Controllers\Api\Client\MainScreenController;
use App\Http\Controllers\Api\Client\OfferController;
use App\Http\Controllers\Api\Client\OrderController;
use App\Http\Controllers\Api\Client\SpecialServiceController;
use App\Http\Controllers\Api\Client\VendorController;
use App\Http\Controllers\Api\Front\ConsultingController as FrontConsultingController;
use App\Http\Controllers\Api\Front\ContactUsController;
use App\Http\Controllers\Api\Front\ContractController;
use App\Http\Controllers\Api\Front\JudgerOrderController;
use App\Http\Controllers\Api\Front\OrderDecryptionRequests;
use App\Http\Controllers\Api\Front\OrderDocumentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Front\EventController;
use App\Http\Controllers\Api\Front\InvoiceController;
use App\Http\Controllers\Api\Front\ObjectionController;
use App\Http\Controllers\Api\Front\ObjectionTalkController;
use App\Http\Controllers\Api\Front\OrderProtestController;
use App\Http\Controllers\Api\Front\PayWithTapController;
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


Route::group(['middleware' => 'auth:sanctum'], function () {
    /* ============== Profile ============== */
    Route::get('settings', [ProfileController::class, 'settings']);
    Route::post('settings', [ProfileController::class, 'updateSettings']);
    Route::post('update-info', [ProfileController::class, 'updateInfo']);
    Route::post('update-financial', [ProfileController::class, 'updateFinancial']);
    Route::get('platforms', [ProfileController::class, 'platforms']);
    Route::post('update-platforms', [ProfileController::class, 'updatePlatforms']);
    /* ============== Orders And Offers ============== */
    Route::group(['middleware' => 'user_is_delete_api'], function () {
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('private-orders', [OrderController::class, 'private']);
        Route::get('orders/create', [OrderController::class, 'create']);
        Route::post('orders', [OrderController::class, 'store']);
        Route::get('orders/{hash_code}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus']);
        Route::post('orders/{order}/cancel', [OrderController::class, 'cancel']);
        Route::post('orders/{order}/accept-order', [OrderController::class, 'acceptOrder']);
        Route::get('orders/{order}/vendors/{vendor}/offers', [OfferController::class, 'vendorOffers']);
        Route::post('offers/{offer}', [OfferController::class, 'update'])->name('offer.update');
        Route::get('orders/{hash_code}/logs', [OrderController::class, 'logs']);
        /* *********************************** Order Documents ****************************** */
        Route::get('orders/{hash_code}/documents', [OrderDocumentController::class, 'index']);
        Route::post('documents', [OrderDocumentController::class, 'store']);
        /* ============== Protests ============== */
        Route::get('orders/{hash_code}/protests', [OrderProtestController::class, 'index']);
        Route::post('protests', [OrderProtestController::class, 'store']);
        /* ********************************** Consulting ****************************** */
        Route::resource('consulting', ConsultingController::class);
        Route::post('consulting/accept-offer', [ConsultingController::class, 'acceptOffer'])->name('consulting.accept.offer');
        Route::post('consulting/evaluate', [ConsultingController::class, 'evaluate'])->name('consulting.evaluate');
        Route::post('consulting/{consulting}/cancel', [FrontConsultingController::class, 'cancel']);

        /* ************************** decryptionRequests ****************************** */
        Route::get('orders/{hash_code}/decryption-requests', [OrderDecryptionRequests::class, 'index']);
        Route::post('decryption-requests/{order}/{vendor}', [OrderDecryptionRequests::class, 'update']);
        /* ***************************************** JudgerOrder ****************************** */
        Route::put('select-judgers', [JudgerOrderController::class, 'clientDecision']);
        /* ***************************************** Contract ****************************** */
        Route::get('orders/{hash_code}/contract', [ContractController::class, 'show']);
        Route::get('orders/{order}/contract/download', [ContractController::class, 'download'])->name('contract.download');
        Route::post('orders/{order}/before-accept-contract', [ContractController::class, 'clientBeforeAccept']);
        Route::post('orders/{order}/contract', [ContractController::class, 'clientAccept']);
        /* ************************************* Events ****************************** */
        Route::get('orders/{hash_code}/events', [EventController::class, 'index'])->name('events');
        Route::get('orders/{hash_code}/events/{event}', [EventController::class, 'show'])->name('events.show');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
        /* ============== Protests ============== */
        Route::get('orders/{hash_code}/protests', [OrderProtestController::class, 'index']);
        Route::post('protests', [OrderProtestController::class, 'store']);
        /* ***************************************** Order Invoices ****************************** */
        Route::get('orders/{hash_code}/invoices', [InvoiceController::class, 'orderInvoices'])->name('invoices.orderInvoices');
        /* *********************************** Objection ****************************** */
        Route::get('objections/{objection}', [ObjectionController::class, 'show']);
        Route::post('objections', [ObjectionController::class, 'store']);
        Route::put('objections/{objection}/seen', [ObjectionController::class, 'seen']);
        Route::put('objections/{objection}/decision', [ObjectionController::class, 'client_decision']);
        Route::post('objection-talks', [ObjectionTalkController::class, 'store']);
        Route::post('objection-judgment', [ObjectionController::class, 'objectionJudgment']);
        /* ============= Special Services ============= */
        Route::resource('specialServices', SpecialServiceController::class);
        Route::post('specialServices/{specialService}/msg', [SpecialServiceController::class, 'storeMessage']);
    });
});
