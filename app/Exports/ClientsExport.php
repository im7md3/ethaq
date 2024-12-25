<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ClientsExport implements FromView
{
    public $clients;
    public function __construct($clients)
    {
        $this->clients = $clients;
    }
    public function view(): View
    {
        return view('exports.clients', [
            'clients' => $this->clients
        ]);
    }
}
