<?php

namespace App\Providers;

use App\Models\AccessVendor;
use App\Models\AdvisorFile;
use App\Models\BankTransfer;
use App\Models\Comment;
use App\Models\Consulting;
use App\Models\ConsultingEvaluation;
use App\Models\ConsultingInvoices;
use App\Models\ConsultingMessages;
use App\Models\ConsultingOffers;
use App\Models\Event;
use App\Models\Invoice;
use App\Models\JudgerOrder;
use App\Models\License;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Objection;
use App\Models\ObjectionTalk;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Refund;
use App\Models\Sms;
use App\Models\SpecialService;
use App\Models\SpecialServiceMessage;
use App\Models\SuspendedBalance;
use App\Models\SuspendedBalanceConsulting;
use App\Models\Ticket;
use App\Models\User;
use App\Models\WebsitePage;
use App\Models\Withdrawal;
use App\Observers\AccessVendorObserver;
use App\Observers\AdvisorFileObserver;
use App\Observers\BankTransferObserver;
use App\Observers\CommentObserver;
use App\Observers\ConsultingEvaluationObserver;
use App\Observers\ConsultingInvoicesObserver;
use App\Observers\ConsultingMessagesObserver;
use App\Observers\ConsultingObserver;
use App\Observers\ConsultingOffersObserver;
use App\Observers\EventObserver;
use App\Observers\InvoiceObserver;
use App\Observers\JudgerOrderObserver;
use App\Observers\LicenseObserver;
use App\Observers\MessageObserver;
use App\Observers\NotificationObserver;
use App\Observers\ObjectionObserver;
use App\Observers\ObjectionTalkObserver;
use App\Observers\OfferObserver;
use App\Observers\OrderObserver;
use App\Observers\RefundObserver;
use App\Observers\SmsObserver;
use App\Observers\SpecialServiceMessageObserver;
use App\Observers\SpecialServiceObserver;
use App\Observers\SuspendedBalanceConsultingObserver;
use App\Observers\SuspendedBalanceObserver;
use App\Observers\TicketObserver;
use App\Observers\UserObserver;
use App\Observers\WebsitePageObserver;
use App\Observers\WithdrawalObserver;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Paginator::useBootstrapFive();
        Blade::if('company', function () {
            return auth()->check() && auth()->user()->membership == 'company';
        });
        Blade::if('individual', function () {
            return auth()->check() && auth()->user()->membership == 'individual';
        });
        Blade::if('client', function () {
            return auth()->check() && auth()->user()->type == 'client';
        });
        Blade::if('clientIndividual', function () {
            return auth()->check() && auth()->user()->type == 'client' && auth()->user()->membership == 'individual';
        });
        Blade::if('clientCompany', function () {
            return auth()->check() && auth()->user()->type == 'client' && auth()->user()->membership == 'company';
        });
        Blade::if('vendor', function () {
            return auth()->check() && auth()->user()->type == 'vendor';
        });
        Blade::if('vendorIndividual', function () {
            return auth()->check() && auth()->user()->type == 'vendor'  && auth()->user()->membership == 'individual';
        });
        Blade::if('vendorCompany', function () {
            return auth()->check() && auth()->user()->type == 'vendor'  && auth()->user()->membership == 'company';
        });
        Blade::if('judger', function () {
            return auth()->check() && auth()->user()->type == 'judger';
        });
        Blade::if('notJudger', function () {
            return auth()->check() && auth()->user()->type !== 'judger';
        });
        Blade::if('admin', function () {
            return auth()->check() && (auth()->user()->type == 'admin' || auth()->user()->type == 'superAdmin');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
        Notification::observe(NotificationObserver::class);
        Message::observe(MessageObserver::class);
        Offer::observe(OfferObserver::class);
        Event::observe(EventObserver::class);
        Objection::observe(ObjectionObserver::class);
        ObjectionTalk::observe(ObjectionTalkObserver::class);
        Invoice::observe(InvoiceObserver::class);
        // SuspendedBalance::observe(SuspendedBalanceObserver::class);
        Withdrawal::observe(WithdrawalObserver::class);
        Refund::observe(RefundObserver::class);
        WebsitePage::observe(WebsitePageObserver::class);
        User::observe(UserObserver::class);
        Ticket::observe(TicketObserver::class);
        Consulting::observe(ConsultingObserver::class);
        ConsultingMessages::observe(ConsultingMessagesObserver::class);
        ConsultingOffers::observe(ConsultingOffersObserver::class);
        JudgerOrder::observe(JudgerOrderObserver::class);
        ConsultingEvaluation::observe(ConsultingEvaluationObserver::class);
        Sms::observe(SmsObserver::class);
        License::observe(LicenseObserver::class);
        AdvisorFile::observe(AdvisorFileObserver::class);
        BankTransfer::observe(BankTransferObserver::class);
        SpecialService::observe(SpecialServiceObserver::class);
        SpecialServiceMessage::observe(SpecialServiceMessageObserver::class);
        Comment::observe(CommentObserver::class);
    }
}
