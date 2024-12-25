<?php

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Client\MainScreenController;
use App\Http\Controllers\Api\Client\VendorController;
use App\Http\Controllers\Api\Front\BalanceController;
use App\Http\Controllers\Api\Front\BankTransferController;
use App\Http\Controllers\Api\Front\ConsultingController;
use App\Http\Controllers\Api\Front\ConsultingMessagesController;
use App\Http\Controllers\Api\Front\ContactUsController;
use App\Http\Controllers\Api\Front\ContractController;
use App\Http\Controllers\Api\Front\DeleteAccountController;
use App\Http\Controllers\Api\Front\DocumentController;
use App\Http\Controllers\Api\Front\InvoiceController;
use App\Http\Controllers\Api\Front\NegotiationController;
use App\Http\Controllers\Api\Front\NotificationController;
use App\Http\Controllers\Api\Front\OrderController;
use App\Http\Controllers\Api\Front\PageController;
use App\Http\Controllers\Api\Front\PayWithAppleController;
use App\Http\Controllers\Api\Front\PayWithClickTapController;
use App\Http\Controllers\Api\Front\PayWithTamamController;
use App\Http\Controllers\Api\Front\PayWithTamaraController;
use App\Http\Controllers\Api\Front\PayWithTapController;
use App\Http\Controllers\Api\Front\QuestionController;
use App\Http\Controllers\Api\Front\ShowJudgerProfile;
use App\Http\Controllers\Api\Front\SliderController;
use App\Http\Controllers\Api\Front\TicketController;
use App\Http\Controllers\Auth\NafathController;
use Illuminate\Support\Facades\Route;
/* ==============  Invoice ============== */

Route::get('invoices/{invoice}/webView', [InvoiceController::class, 'webView'])->name('invoice.webview');
/* ==============  Auth ============== */
Route::post('login/sms', [LoginController::class, 'sendOtp'])->middleware('guest:sanctum');
Route::post('login/verify/sms', [LoginController::class, 'verifyOtp'])->middleware('guest:sanctum');
Route::post('logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');
/* Route::post('register/sms', [RegisterController::class, 'sendOtp'])->middleware('guest:sanctum');
Route::post('createUser', [RegisterController::class, 'createUser'])->middleware('guest:sanctum'); */
Route::get('check-register-method', [NafathController::class, 'checkRegisterMethod']);
/* =========== Register Page For Vendor on Webview========= */
Route::get('vendor-register', [RegisterController::class, 'vendorRegister'])->name('vendorRegister.webview');
/* =========== Register Page For Client on Webview========= */
Route::get('client-register', [RegisterController::class, 'clientRegister'])->name('clientRegister.webview');
/* ============== Pay With Apple ============== */
Route::get('apple/pay', [PayWithAppleController::class, 'pay'])->name('apple.pay');
/* ============== Tap ============== */
// Route::any('callback/{invoice}', [PayWithTapController::class, 'callback'])->name('tap.callback');
/* ==============** Pay With Click ============== */
Route::any('clickpay/{invoice}', [PayWithClickTapController::class, 'payment'])->name('clickpay.store');
Route::any('clickpay-callback', [PayWithClickTapController::class, 'callbackOrders'])->name('clickpay.callback');
/* ==============** Pay Tamara ============== */
Route::any('tamara/{invoice}', [PayWithTamaraController::class, 'payment'])->name('tamara');
Route::any('tamara-callback', [PayWithTamaraController::class, 'callbackOrders'])->name('tamara.callback');

/* ==============** Pay Tamam ============== */
Route::any('tamam/{invoice}', [PayWithTamamController::class, 'tamam'])->name('tamam');
Route::any('tamam/{invoice}/callback', [PayWithTamamController::class, 'callbackOrders'])->name('tamam.callback');

/* ==============  success or fail paid ============== */
Route::get('paid/success', function () {
})->name('pay.success');
Route::get('paid/fail', function () {
})->name('pay.fail');
/* ==============  Contract ============== */
Route::get('orders/{hash_code}/contract/web-view', [ContractController::class, 'webView'])->name('contracts.webView');
/* ============== Main Screen ============== */
Route::get('client/main-screen', [MainScreenController::class, 'mainScreen']);
/* ============== Search About Vendor ============== */
Route::get('client/vendors', [VendorController::class, 'vendors']);
Route::get('client/vendor/{id}/profile', [VendorController::class, 'vendorShow']);
Route::get('client/vendors-search', [VendorController::class, 'search']);
Route::get('client/vendors-more', [VendorController::class, 'more']);
/* ==============  Contacts ============== */
Route::post('contact-us', [ContactUsController::class, 'store']);
/* ============== Politics ============== */
Route::get('/politics/webview', function () {
    return view('api.politics');
})->name('politics');
/* ============== Politics ============== */
Route::get('/gold/webview', function () {
    return view('api.gold');
})->name('gold');
/* ============== Politics ============== */
Route::get('/specialServices/webview', function () {
    return view('api.specialServices');
})->name('specialServices');
/* ============== Conditions Consulting Services ============== */
Route::get('vendor/conditions-consulting-services/webview', function () {
    return view('api.conditions-consulting-services');
})->name('conditions-consulting-services');
/* ============== Slider ============== */
Route::get('sliders', [SliderController::class, 'sliders']);
/* ==============  Pages ============== */
Route::get('/page/{page}', [PageController::class, 'show']);

/* ==============  Arbitration Regulations ============== */
Route::get('/arbitration-regulations/webview', function () {
    return view('api.arbitration-regulations');
})->name('arbitrationRegulations');

/* ==============  Questions ============== */
Route::get('client/questions', [QuestionController::class, 'clientQuestion']);
Route::get('vendor/questions', [QuestionController::class, 'vendorQuestion']);
/* ==============  Auth Sanctum Routes ============== */
Route::group(['middleware' => 'auth:sanctum'], function () {
    /* ============== Delete Account ============== */
    Route::post('delete-account', [DeleteAccountController::class, 'destroy'])->middleware('user_is_delete_api');
    /* ============== Negotiation ============== */
    Route::post('negotiations/{negotiation}/message', [NegotiationController::class, 'storeMessage'])->middleware('user_is_delete_api');
    Route::get('orders/{order}/negotiations/{negotiation}', [NegotiationController::class, 'getMessages'])->middleware('user_is_delete_api');
    /* ============== Invoices ============== */
    Route::get('invoices', [InvoiceController::class, 'index'])->middleware('user_is_delete_api');
    Route::get('invoices/{invoice}/show', [InvoiceController::class, 'show']);
    /* Route::post('invoices/{invoice}', [PayWithTapController::class, 'payment']); */
    /* ============== Documents ============== */
    Route::post('license', [DocumentController::class, 'license']);
    Route::post('advisorFiles', [DocumentController::class, 'advisorFiles']);
    Route::post('commercial', [DocumentController::class, 'commercial']);
    Route::post('company-info', [DocumentController::class, 'companyInfo']);
    /* ==============  Notifications ============== */
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/store', [NotificationController::class, 'store']);
    /* ============== Test Notification Firebase ============== */
    Route::post('test-firebase', [NotificationController::class, 'testFirebase']);
    /* ============== Balance ============== */
    Route::get('/balance', [BalanceController::class, 'index'])->middleware('user_is_delete_api');
    Route::post('/withdrawals', [BalanceController::class, 'withdrawal'])->middleware('user_is_delete_api');
    /* ============== Tickets ============== */
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/storeComment/{ticket}', [TicketController::class, 'storeComment']);
    /* ============== Consulting ============== */
    Route::group(['middleware' => 'user_is_delete_api'], function () {
        Route::get('consulting/{id}/get-time', [ConsultingController::class, 'getTime']);
        Route::post('consulting/{id}/set-time', [ConsultingController::class, 'setTime']);
        Route::post('consulting/{id}/change-status', [ConsultingController::class, 'changeStatus']);
        Route::post('consulting/{id}/update-call', [ConsultingController::class, 'updateCall']);
        Route::post('consulting/{id}/end', [ConsultingController::class, 'end']);
        Route::post('consulting/{consulting}/cancel', [ConsultingController::class, 'cancel']);
        /* ============== Consulting Messages ============== */
        Route::get('consulting-messages/{consulting}', [ConsultingMessagesController::class, 'index']);
        Route::post('consulting-messages', [ConsultingMessagesController::class, 'store']);
        Route::post('consulting-messages/get-time', [ConsultingMessagesController::class, 'getTime']);
        /* ============== Judger Profile ============== */
        Route::get('judgers/{judger}/profile', [ShowJudgerProfile::class, 'profile']);
        /* ============== bank payment ============== */
        Route::post('bank/{invoice}', [BankTransferController::class, 'payment'])->name('bank.store');
        /* ============== Pusher Credential ============== */
        Route::get('pusher', function () {
            $PUSHER_APP_ID = env('PUSHER_APP_ID');
            $PUSHER_APP_KEY = env('PUSHER_APP_KEY');
            $PUSHER_APP_SECRET = env('PUSHER_APP_SECRET');
            $PUSHER_APP_CLUSTER = env('PUSHER_APP_CLUSTER');
            $data = ['PUSHER_APP_ID' => $PUSHER_APP_ID, 'PUSHER_APP_KEY' => $PUSHER_APP_KEY, 'PUSHER_APP_SECRET' => $PUSHER_APP_SECRET, 'PUSHER_APP_CLUSTER' => $PUSHER_APP_CLUSTER];
            return responseApi(true, '', $data);
        });
    });
});
