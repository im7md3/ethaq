<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\WebsitePage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(WebsitePage $page){
        return $page;
    }
}
