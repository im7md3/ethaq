<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ConsultingExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $consultings;
    public function __construct($consultings)
    {
        $this->consultings = $consultings;
    }
    public function view(): View
    {

        return view('exports.consultings', [
            'consultings' => $this->consultings
        ]);
    }
}
