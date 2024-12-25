<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;
use Prgayman\Zatca\Facades\Zatca;
use App\Http\Controllers\Controller;
use App\Service\Oursms;
use Prgayman\Zatca\Utilis\QrCodeOptions; // Optional

class ContractController extends Controller
{

    public function show($hash)
    {
        $order = Order::where('hash_code', $hash)->first();
        $qr = null;
        if ($order->invoices()->count() > 0) {
            $invoice = $order->invoices()->where('for_type', 'vendor')->first();
            $qrCodeOptions = new QrCodeOptions();
            $qrCodeOptions->format('svg');
            $qrCodeOptions->backgroundColor(255, 255, 255);
            $qrCodeOptions->color(0, 0, 0);
            $qrCodeOptions->size(125);
            $qrCodeOptions->margin(0);
            $qrCodeOptions->style('square', 0.5);
            $qrCodeOptions->eye('square');
            if (strlen(setting('tax_number')) == 15) {
                $qr = Zatca::sellerName(setting('website_name'))
                    ->vatRegistrationNumber(setting('tax_number'))
                    ->timestamp($invoice->created_at)
                    ->totalWithVat($invoice->total)
                    ->vatTotal($invoice->tax)
                    ->toQrCode($qrCodeOptions);
            }
        }
        return view(auth()->user()->type . '.order.view-contract', compact('order', 'qr'));
    }
    public function vendorAccept(Request $request, Order $order)
    {
        $data = $request->validate(['vendor_contract' => 'required']);
        $order->update($data);
        return redirect()->route('vendor.orders.show', $order->hash_code)->with('success', 'تم قبول وإرسال العقد للعميل بنجاح');
    }
    public function clientBeforeAccept(Request $request, Order $order)
    {
        $code = rand(10000, 99999);
        $order->update(['code_accept_contract' => $code]);
        $message = 'كود قبول العقد:' . $code;
        // try {

        // } catch (\Throwable $e) {
        //     return redirect()->back()->with('error', $e->getMessage());
        // }
        Oursms::send(auth()->user()->phone, $message);
        // sendSms(auth()->id(), 'client_code_for_accepted_contract', $message);
        return back()->with('success', 'تم إرسال الكود بنجاح');
    }
    public function clientAccept(Request $request, Order $order)
    {
        $data = $request->validate(['code' => 'required']);
        if ($request->code !== $order->code_accept_contract) {
            return back()->with('error', 'الكود المدخل غير صحيح');
        }
        $ff = view('components.order.contract', compact('order'))->render();
        $order->update(['contract' => $ff, 'accepted_contract_date' => now()]);
        return redirect()->route('client.orders.show', $order->hash_code)->with('success', 'تم قبول العقد وإنشائه بنجاح');
    }
}
