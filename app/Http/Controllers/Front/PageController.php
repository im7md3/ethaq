<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\WebsitePage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug){
        $page=WebsitePage::where('slug',$slug)->first();
        return view('front.page',compact('page'));
    }
}
