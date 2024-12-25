<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prgayman\Zatca\Facades\Zatca;
use Prgayman\Zatca\Utilis\QrCodeOptions; // Optional
class InvoiceController extends Controller
{
    public function index()
    {
        $user = auth()->id();
        $invoices = Invoice::with('order')->where('from_id', $user)->orWhere('to_id', $user)->latest('id')->paginate(10);
        return responseApi(true, '', ['invoices' => $invoices]);
    }
    public function show(Invoice $invoice)
    {
        $qrCodeOptions = new QrCodeOptions();
        $qrCodeOptions->format('svg');
        $qrCodeOptions->backgroundColor(255, 255, 255);
        $qrCodeOptions->color(0, 0, 0);
        $qrCodeOptions->size(125);
        $qrCodeOptions->margin(0);
        $qrCodeOptions->style('square', 0.5);
        $qrCodeOptions->eye('square');
        if (strlen(setting('tax_number')) == 15) {
            $qrCode = Zatca::sellerName(setting('website_name'))
                ->vatRegistrationNumber(setting('tax_number'))
                ->timestamp($invoice->created_at)
                ->totalWithVat($invoice->total)
                ->vatTotal($invoice->tax ?? 15)
                ->toQrCode($qrCodeOptions);
        }
        $data = ['qrCode' => $qrCode, 'invoice' => $invoice];
        return responseApi(true, '', $data);
    }
    public function webView(Invoice $invoice)
    {
        $user_id=request('user_id');
        $user_type=request('user_type');
        $qrCodeOptions = new QrCodeOptions();
        $qrCodeOptions->format('svg');
        $qrCodeOptions->backgroundColor(255, 255, 255);
        $qrCodeOptions->color(0, 0, 0);
        $qrCodeOptions->size(125);
        $qrCodeOptions->margin(0);
        $qrCodeOptions->style('square', 0.5);
        $qrCodeOptions->eye('square');
        if (strlen(setting('tax_number')) == 15) {
            $qrCode = Zatca::sellerName(setting('website_name'))
                ->vatRegistrationNumber(setting('tax_number'))
                ->timestamp($invoice->created_at)
                ->totalWithVat($invoice->total)
                ->vatTotal($invoice->tax ?? 15)
                ->toQrCode($qrCodeOptions);
        }
        return view('api.invoice', compact('qrCode', 'invoice','user_id','user_type'));
    }
    public function orderInvoices($hash_code)
    {
        $tax_rate = setting('contract_tax');
        $order = Order::where('hash_code', $hash_code)->first();
        $invoices = Invoice::where('order_id', $order->id)->get();
        return responseApi(true, '', ['invoices' => $invoices, 'tax_rate' => $tax_rate]);
    }
}
