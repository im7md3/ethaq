<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class VendorsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $vendors;
    public function __construct($vendors)
    {
        $this->vendors=$vendors;
    }
    public function view(): View
    {

            return view('exports.vendors', [
                'vendors' => $this->vendors
            ]);

    }
}
