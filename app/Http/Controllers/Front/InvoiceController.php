<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Service\Tap;
use Illuminate\Http\Request;
use Prgayman\Zatca\Facades\Zatca;
use Prgayman\Zatca\Utilis\QrCodeOptions; // Optional
class InvoiceController extends Controller
{
    public function index(){
        $user=auth()->user()->loadCount(['invoices'=>function($q){
            $q->where('status','unpaid');
        }]);
        $invoices=Invoice::with('order')->where('from_id',$user->id)->orWhere('to_id',$user->id)->latest('id')->paginate(10);
        return view('front.invoices.index',compact('user','invoices'));
    }
    public function show(Invoice $invoice){
        $user=auth()->user()->loadCount(['invoices'=>function($q){
            $q->where('status','unpaid');
        }]);
        $qrCodeOptions = new QrCodeOptions();
        $qrCodeOptions->format('svg');
        $qrCodeOptions->backgroundColor(255, 255, 255);
        $qrCodeOptions->color(0, 0, 0);
        $qrCodeOptions->size(125);
        $qrCodeOptions->margin(0);
        $qrCodeOptions->style('square', 0.5);
        $qrCodeOptions->eye('square');
        if(strlen(setting('tax_number')) == 15){
            $qrCode = Zatca::sellerName(setting('website_name'))
                ->vatRegistrationNumber(setting('tax_number'))
                ->timestamp($invoice->created_at)
                ->totalWithVat($invoice->total)
                ->vatTotal($invoice->tax ?? 15)
                ->toQrCode($qrCodeOptions);
        }
        return view('front.invoices.show',compact('qrCode','invoice','user'));
    }
    public function orderInvoices($hash_code){
        $order=Order::withCount(['documents','events'=>function($q){
            $q->whereNull('is_seen');
        },'invoices'=>function($q){
            $q->where('from_id',auth()->id());
        }])->where('hash_code',$hash_code)->first();
        $user=auth()->user();
        $invoices=Invoice::where('order_id',$order->id)->paginate(10);
        return view($user->type.'.order.invoices',compact('order','user','invoices'));
    }
    
}
