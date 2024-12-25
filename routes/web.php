<?php

use App\Http\Controllers\Api\Front\BankTransferController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NafathController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\YakeenController;
use App\Http\Controllers\Front\BalanceController;
use App\Http\Controllers\Front\ContactUsController;
use App\Http\Controllers\Front\NotificationController as FrontNotificationController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\PayWithClickTapController;
use App\Http\Controllers\Front\PayWithTamaraController;
use App\Http\Controllers\Front\ShowJudgerProfile;
use App\Http\Controllers\Front\TicketController;
use App\Http\Controllers\Front\VendorController;
use App\Http\Controllers\Front\PayWithTamamController;
use App\Http\Controllers\VoiceCallController;
use App\Models\Consulting;
use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\Ip;
use Illuminate\Support\Facades\Route;
use App\Models\Question;
use App\Models\User;

/* ==================== Shared Routes between Users ==================== */
/* ==================== AUTH ==================== */

Route::post('login/sms', [LoginController::class, 'sendOtp']);
Route::post('login/verify/sms', [LoginController::class, 'verifyOtp']);
Route::view('client/register', 'auth.client-register')->name('client.register');
Route::get('vendor/register', [RegisterController::class, 'vendorRegister'])->name('vendor.register');
Route::post('register/sms', [RegisterController::class, 'sendOtp']);
Route::post('createUser', [RegisterController::class, 'createUser']);
Route::get('register/nafath', [NafathController::class, 'nafath'])->name('register.nafath');
Route::any('register/membership', [NafathController::class, 'membership'])->name('register.membership');
Auth::routes(['register' => false]);
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::get('yakeen/otp', [YakeenController::class, 'otp'])->name('yakeen.otp');

/* ==================== URL('/') ==================== */
Route::get('/', function () {
    if (auth()->check() and auth()->user()->type == 'client') {
        return redirect()->route('client.profile');
    } elseif (auth()->check() and auth()->user()->type == 'vendor') {
        return redirect()->route('vendor.home');
    } elseif (auth()->check() and auth()->user()->type == 'judger') {
        return redirect()->route('judger.home');
    } elseif (auth()->check() and auth()->user()->type == 'admin') {
        return redirect()->route('admin.home');
    }
    $questions = Question::paginate(5);
    Ip::store(request(), 'visitor');
    return view('front.welcome', compact('questions'));
});
/* ====================  Questions ==================== */
Route::get('questions', function () {
    $questions = Question::paginate(5);
    return view('front.questions', compact('questions'));
})->name('questions');
/* ====================  Politics ==================== */
Route::view('/politics', 'front.politics')->name('politics');
/* ====================  Contacts ==================== */
Route::view('/contact-us', 'front.contact')->name('contact');
Route::post('contact-us/store', [ContactUsController::class, 'store'])->name('contactUs.store');
/* ====================  Pages ==================== */
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');
/* ==============** Pay With Click ============== */
Route::any('invoices/{invoice}', [PayWithClickTapController::class, 'payment'])->name('clickpay.store');
Route::any('clickpay-callback', [PayWithClickTapController::class, 'callbackOrders'])->name('clickpay.callback');
/* ==============** Pay Tamam ============== */
Route::any('tamam/po_callback', [PayWithTamamController::class, 'poCallback'])->name('tamam.po');
Route::any('tamam/status_callback', [PayWithTamamController::class, 'statusCallback'])->name('tamam.status_callback');
Route::any('tamam/{invoice}', [PayWithTamamController::class, 'tamam'])->name('tamam');
Route::any('tamam/{invoice}/transaction', [PayWithTamamController::class, 'transaction'])->name('tamam.transaction');
Route::any('tamam/{invoice}/callback', [PayWithTamamController::class, 'callbackOrders'])->name('tamam.callback');
/* ==============** Pay Tamara ============== */
Route::any('tamara/{invoice}', [PayWithTamaraController::class, 'payment'])->name('tamara');
Route::any('tamara-callback', [PayWithTamaraController::class, 'callbackOrders'])->name('tamara.callback');
/* ==============*** Search About Vendor ============== */
Route::get('vendors', [VendorController::class, 'vendors'])->name('allVendors');
Route::get('vendor/{id}/profile', [VendorController::class, 'vendorShow'])->name('vendor.profile');
Route::get('createConsultation/{vendor}', [VendorController::class, 'createConsultation'])->name('createConsultation');
Route::post('createConsultation/', [VendorController::class, 'storeConsultation'])->name('storeConsultation');

/* *********************************  Auth Routes ==================== */
Route::group(['middleware' => 'auth'], function () {
    /* ====================  Arbitration Regulations ==================== */
    Route::view('/arbitration-regulations', 'front.arbitration-regulations')->name('arbitrationRegulations');
    /* ***************************  Notifications ==================== */
    Route::get('/notifications', [FrontNotificationController::class, 'index'])->name('notification');
    /* ====================*** Tickets ==================== */
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/storeComment/{id}', [TicketController::class, 'storeComment'])->name('tickets.storeComment');
    /* ==================== Balance ==================== */
    Route::get('/balance', [BalanceController::class, 'index'])->middleware('user_is_delete')->name('balance');
    Route::post('/withdrawals', [BalanceController::class, 'withdrawal'])->name('withdrawals');
    /* ==================== Judger Profile ==================== */
    Route::get('judgers/{judger}/profile', [ShowJudgerProfile::class, 'profile'])->name('judger.profile');
    /* ==============** Pay With Click ============== */
    Route::any('bank/{invoice}', [BankTransferController::class, 'payment'])->name('bank.store');
});

Route::get('/agora-chat', [VoiceCallController::class, 'index']);
Route::post('/agora/token', [VoiceCallController::class, 'token']);
Route::post('/agora/call-user', [VoiceCallController::class, 'callUser']);
Route::view('/voice-call', 'voice-call')->name('voice-call.make');
// consulting-landing
Route::view('/consultingLanding', 'consulting-landing.index');