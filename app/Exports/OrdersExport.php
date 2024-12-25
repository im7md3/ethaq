<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class OrdersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $orders;
    public function __construct($orders)
    {
        $this->orders=$orders;
    }
    public function view(): View
    {
            return view('exports.orders', [
                'orders' => $this->orders
            ]);

    }
}
