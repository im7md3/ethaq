<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsitePage;
use Illuminate\Http\Request;
use App\Traits\JodaResource;
class WebsitePagesController extends Controller
{
    use JodaResource;
    public $model='App\Models\WebsitePage';
    public $rules = [
        'title' => 'required|string',
            'content' => 'required',
            'status' => 'required|boolean'
    ];
  
    public function query($query){
        return $query->latest()->paginate(10);
    }

    
}
