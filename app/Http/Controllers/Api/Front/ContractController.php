<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use CobraProjects\Arabic\Arabic;
use Prgayman\Zatca\Facades\Zatca;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\Oursms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Prgayman\Zatca\Utilis\QrCodeOptions;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    public function show($hash)
    {
        $order = Order::where('hash_code', $hash)->with('invoices')->first();
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
        $message = 'تم إرسال العقد الخاص بالطلب ' . $order->id;
        $user = User::find($order->client_id);
        Oursms::send($user->phone, $message);
        $contract = route('api.front.contracts.webView', $order->hash_code);
        $data = ['order' => $order, 'qr' => $qr, 'contract' => $contract];
        return responseApi(true, '', $data);
    }

    public function webView($hash)
    {
        $order = Order::where('hash_code', $hash)->with('invoices')->first();
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
        return view('api.contract', compact('order', 'qr'));
    }

    public function vendorAccept(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'vendor_contract' => 'required'
        ]);
        if ($validator->fails()) {
            return responseApi(false, $validator->errors()->first(), null, $validator->errors());
        }
        $order->update($request->all());
        return responseApi(true, 'تم قبول وإرسال العقد للعميل بنجاح', ['order' => $order]);
    }

    public function clientBeforeAccept(Request $request, Order $order)
    {
        $user = auth('sanctum')->user();
        $code = rand(10000, 99999);
        $order->update(['code_accept_contract' => $code]);
        $message = 'كود قبول العقد:' . $code;
        Oursms::send($user->phone, $message);
        // sendSms(auth('sanctum')->id(), 'client_code_for_accepted_contract', $message);
        return responseApi(true, 'تم إرسال الكود بنجاح');
    }

    public function clientAccept(Request $request, Order $order)
    {
        $data = $request->validate(['code' => 'required']);
        if ($request->code !== $order->code_accept_contract) {
            return responseApi(false, 'الكود المدخل غير صحيح');
        }
        $ff = view('components.order.contract', compact('order'))->render();
        $order->update(['contract' => $ff, 'accepted_contract_date' => now()]);
        return responseApi(true, 'تم قبول العقد وإنشائه بنجاح', ['order' => $order]);
    }

    public function download(Order $order)
    {

        $Arabic = new Arabic('Glyphs');
        $pdfContentArray = explode('</style>', $order->contract,);
        $pdfContent = $pdfContentArray[1];
        $new_str = trim($pdfContent);
        $htmlWithoutR = preg_replace("@\r@", "", $new_str);
        $pdfContent = preg_replace('/<[^>]+>/', '', $htmlWithoutR);
        $pdfContent = $Arabic->utf8Glyphs($pdfContent);
        $pdf = PDF::loadHTML($pdfContent);
        $filename = $order->id . '-' . time() . '.pdf';
        $pdf->save('uploads/contracts/' . $filename);
        return display_file("contracts/" . $filename);
    }
}
