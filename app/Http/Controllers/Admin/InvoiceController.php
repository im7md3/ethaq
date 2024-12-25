<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Prgayman\Zatca\Facades\Zatca;
use App\Http\Controllers\Controller;
use Prgayman\Zatca\Utilis\QrCodeOptions; // Optional

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read_invoices')->only('index');
        $this->middleware('can:update_invoices')->only('update');
    }

    public function between($query)
    {
        if (request()->from && request()->to) {
            $query->whereBetween('created_at', [request()->from, request()->to]);
        } elseif (request()->from) {
            $query->where('created_at', '>=', request()->from);
        } elseif (request()->to) {
            $query->where('created_at', '<=', request()->to);
        } else {
            $query;
        }
    }
    public function index()
    {
        $allInvoices = Invoice::where(function ($q) {
            $this->between($q);
            if (request('status')) {
                $q->where('status', request('status'));
            }
        })->get();
        //         request_done
        // done
        // ongoing
        // close
        $invoices = Invoice::with(['fromUser', 'toUser'])->where(function ($q) {
            $this->between($q);
            if (request('status')) {
                $q->where('status', request('status'));
            }
            if (request('invoice_no')) {
                $q->where('id', request('invoice_no'));
            }
        })->when(request('type'), function ($q) {
            if (request('type') == 'order') {
                $q->where('order_type', 'App\Models\Order');
            } else {
                $q->where('order_type', 'App\Models\Consulting');
            }
        })->when(request('member'), function ($q) {
            if (request('member') == 'client') {
                $q->whereHas('toUser', function ($query) {
                    $query->where('type', 'client');
                });
            } else {
                $q->whereHas('toUser', function ($query) {
                    $query->where('type', 'vendor');
                });
            }
        })->latest('id')->paginate(10);
        return view('admin.invoices.index', compact('invoices', 'allInvoices'));
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
        return view('admin.invoices.show', compact('qrCode', 'invoice'));
    }

    public function update(Invoice $invoice, Request $request)
    {
        $request->validate(['status' => 'required']);

        $invoice->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }
}
