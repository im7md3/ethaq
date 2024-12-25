<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdvisorController;
use App\Http\Controllers\Admin\AdvisorFileController;
use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BankTransferController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CommercialController;
use App\Http\Controllers\Admin\ConsultingController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\IPController;
use App\Http\Controllers\Admin\JudgerController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Admin\MembershipSettingController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OccupationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PlatformController;
use App\Http\Controllers\Admin\QualificationController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\SpecialServiceController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\SuspendedBalances;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\Admin\WebsitePagesController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Front\ContractController;
use App\Http\Controllers\Front\EventController;
use App\Http\Controllers\Front\InvoiceController;
use App\Http\Controllers\Front\ObjectionController;
use App\Http\Controllers\Front\OrderDocumentController;
use Illuminate\Support\Facades\Route;

Route::view('login', 'admin.login')->middleware('admin_guest')->name('login');
Route::post('login', [AuthController::class, 'login'])->middleware('admin_guest')->name('login.post');
Route::group(['middleware' => 'admin'], function () {
    Route::get('/', function () {
        return view('admin.home');
    })->name('home');
    /* ============= Settings ============= */
    Route::get('settings/general', [SettingsController::class, 'general'])->name('settings.general');
    Route::put('settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.updateGeneral');
    Route::get('settings/membership', [SettingsController::class, 'memberships'])->name('settings.memberships');
    Route::put('settings/updateMembership', [SettingsController::class, 'updateMemberships'])->name('settings.updateMemberships');
    Route::get('settings/orders', [SettingsController::class, 'orders'])->name('settings.orders');
    Route::put('settings/orders', [SettingsController::class, 'updateOrders'])->name('settings.updateOrders');
    Route::get('settings/sms', [SettingsController::class, 'sms'])->name('settings.sms');
    Route::put('settings/updateSMS', [SettingsController::class, 'updateSMS'])->name('settings.updateSMS');
    Route::get('settings/social-media', [SettingsController::class, 'socialMedia'])->name('settings.socialMedia');
    Route::put('settings/update-social-media', [SettingsController::class, 'updateSocialMedia'])->name('settings.updateSocialMedia');
    Route::get('settings/consulting', [SettingsController::class, 'consulting'])->name('settings.consulting');
    Route::put('settings/consulting', [SettingsController::class, 'updateConsulting'])->name('settings.updateConsulting');
    Route::get('settings/politics', [SettingsController::class, 'politics'])->name('settings.politics');
    Route::put('settings/politics', [SettingsController::class, 'updatePolitics'])->name('settings.updatePolitics');
    Route::get('settings/arbitration-regulations', [SettingsController::class, 'arbitrationRegulations'])->name('settings.arbitrationRegulations');
    Route::put('settings/arbitration-regulations', [SettingsController::class, 'updateArbitrationRegulations'])->name('settings.updateArbitrationRegulations');
    Route::get('settings/gold', [SettingsController::class, 'gold'])->name('settings.gold');
    Route::put('settings/gold', [SettingsController::class, 'updateGold'])->name('settings.updateGold');
    Route::get('settings/invoices', [SettingsController::class, 'invoices'])->name('settings.invoices');
    Route::put('settings/invoices', [SettingsController::class, 'updateInvoices'])->name('settings.updateInvoices');
    Route::get('settings/specialServices', [SettingsController::class, 'specialServices'])->name('settings.specialServices');
    Route::put('settings/specialServices', [SettingsController::class, 'updateSpecialServices'])->name('settings.updateSpecialServices');
    /* ============= Website Pages ============= */
    Route::resource('website-pages', WebsitePagesController::class);
    // use JodaResource
    /* ============= Departments ============= */
    Route::resource('departments', DepartmentController::class);
    Route::get('departments/{department}/users', [DepartmentController::class, 'users'])->name('departments.users');
    Route::get('sub_departments', [DepartmentController::class, 'sub_departments'])->name('departments.sub_departments');
    /* ============= Banks ============= */
    Route::resource('banks', BankController::class);
    /* ============= Countries & Cities ============= */
    Route::resource('countries', CountryController::class);
    Route::resource('cities', CityController::class);
    /* ============= Alerts ============= */
    Route::resource('alerts', AlertController::class);
    /* ============= Admins ============= */
    Route::resource('admins', AdminController::class);
    /* ============= Admins ============= */
    Route::resource('roles', RoleController::class);
    /* ============= Users ============= */
    Route::resource('clients', ClientController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('advisors', AdvisorController::class);
    Route::get('vendors-qualifications-specialties-statistics', [VendorController::class, 'qualificationsAndSpecialties'])->name('vendors.qualifications.specialties.statistics');
    Route::get('vendors-cities-statistics', [VendorController::class, 'cities'])->name('vendors.cities.statistics');
    Route::get('not-consultation-price', [VendorController::class, 'notConsultationPrice'])->name('vendors.notConsultationPrice');
    Route::get('not-consultation-price-advisors', [AdvisorController::class, 'notConsultationPrice'])->name('advisors.notConsultationPrice');
    Route::get('vendors-export', [VendorController::class, 'exports'])->name('vendors.exports');
    Route::get('consultings-export', [ConsultingController::class, 'exports'])->name('consultings.exports');
    Route::get('clients-export', [ClientController::class, 'exports'])->name('clients.exports');
    Route::resource('judgers', JudgerController::class);
    Route::get('active-requests', [UserController::class, 'activeRequests'])->name('user.active_requests');
    Route::post('users/block/{user}', [UserController::class, 'block'])->name('users.block');
    /* ============= deleted-members ============= */
    Route::get('/deleted-members', [UserController::class, 'deletedUsers'])->name('deletedUsers');
    Route::post('/return-user/{user}', [UserController::class, 'returnUser'])->name('returnUser');
    /* ============= Notes ============= */
    Route::resource('notes', NoteController::class);
    /* ============= Special Services ============= */
    Route::resource('specialServices', SpecialServiceController::class);
    Route::post('specialServices/{specialService}/msg', [SpecialServiceController::class, 'storeMessage'])->name('specialServices.msg');
    /* ============= Orders ============= */
    Route::get('orders/preview/{hash_code}', [OrderController::class, 'show'])->name('orders.show');
    Route::resource('orders', OrderController::class)->except('show');
    Route::get('orders/preview/{hash_code}/logs', [OrderController::class, 'logs'])->name('orders.log');
    Route::get('orders/{hash_code}/contract}', [ContractController::class, 'show'])->name('contracts.show');
    Route::get('orders/preview/{hash_code}/invoices', [InvoiceController::class, 'orderInvoices'])->name('invoices.orderInvoices');
    Route::get('orders/preview/{hash_code}/events', [EventController::class, 'index'])->name('events');
    Route::get('orders/{hash_code}/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('orders/preview/{hash_code}/objection', [ObjectionController::class, 'index'])->name('objection');
    Route::get('orders-export', [OrderController::class, 'exports'])->name('orders.exports');
    /* ==============***** Documents ============== */
    Route::get('orders/{hash_code}/documents', [OrderDocumentController::class, 'index'])->name('documents');
    /* ============= Notifications ============= */
    Route::resource('notifications', NotificationController::class);
    Route::get('admin-notifications', [NotificationController::class, 'admin'])->name('admin_notifications');
    Route::post('notifications/admin-delete-all', [NotificationController::class, 'adminDeleteAll'])->name('notifications.AdminDeleteAll');
    Route::post('notifications/users-delete-all', [NotificationController::class, 'usersDeleteAll'])->name('notifications.usersDeleteAll');
    Route::post('notifications/delete-selected', [NotificationController::class, 'deleteSelected'])->name('notifications.deleteSelected');
    /* ============= advisor files ============= */
    Route::resource('advisorFile', AdvisorFileController::class);
    /* ============= Documents ============= */
    Route::resource('licenses', LicenseController::class);
    Route::post('license', [DocumentController::class, 'license'])->name('license');
    Route::put('license/{license}', [DocumentController::class, 'licenseUpdate'])->name('license.update');
    Route::post('commercial', [DocumentController::class, 'commercial'])->name('commercial');
    Route::post('company-info', [DocumentController::class, 'companyInfo'])->name('company.info');
    /* ============= Occupations ============= */
    Route::resource('occupations', OccupationController::class);
    /* ============= Specialties ============= */
    Route::resource('specialties', SpecialtyController::class);
    /* ============= Qualifications ============= */
    Route::resource('qualifications', QualificationController::class);
    /* ============= Questions ============= */
    Route::resource('questions', QuestionController::class);
    /* ============= Tickets ============= */
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/storeComment', [TicketController::class, 'storeComment'])->name('tickets.storeComment');
    /* ============= Contactus ============= */
    Route::resource('contact-us', ContactUsController::class);
    /* ============= Email Templates ============= */
    Route::resource('email_templates', EmailTemplateController::class);
    /* ============= Suspended Balances  ============= */
    Route::resource('suspended-balances', SuspendedBalances::class);
    /* ============= Withdrawals  ============= */
    Route::resource('withdrawals', WithdrawalController::class);
    /* ============= bank Transfers  ============= */
    Route::resource('bankTransfers', BankTransferController::class);
    /* ============= Refunds  ============= */
    Route::resource('refunds', RefundController::class);
    /* ============= invoices  ============= */
    Route::get('invoices/{invoice}/show', [AdminInvoiceController::class, 'show'])->name('invoices.show');
    Route::resource('invoices', AdminInvoiceController::class)->except('show');
    /* ============= Consulting ============= */
    Route::get('consulting/clients', [ConsultingController::class, 'clients'])->name('consulting.clients');
    Route::resource('consulting', ConsultingController::class);
    /* ============= Email Templates ============= */
    Route::delete('ips/delete-all', [IPController::class, 'destroyAll'])->name('ips.destroy.all');
    Route::resource('ips', IPController::class);
    /* ============= Slider ============= */
    Route::resource('sliders', SliderController::class);
    /* ============= SMS ============= */
    Route::get('sms/users', [SmsController::class, 'users'])->name('sms.users');
    Route::post('sms/users', [SmsController::class, 'usersStore'])->name('sms.users.store');
    Route::get('sms/departments', [SmsController::class, 'departments'])->name('sms.departments');
    Route::post('sms/departments', [SmsController::class, 'departmentsStore'])->name('sms.departments.store');
    Route::resource('sms', SmsController::class);
    /* ============= Platforms ============= */
    Route::resource('platforms', PlatformController::class);
});

/* ============= invoice ============= */
Route::view('/invoice', 'admin.invoice.index')->name('invoice');

/* ============= invoice ============= */
Route::view('/attorneys-contract', 'admin.attorneys-contract')->name('attorneysContract');
