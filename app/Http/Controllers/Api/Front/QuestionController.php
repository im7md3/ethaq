<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function clientQuestion(){
        $questions=Question::where('type','client')->orWhereNull('type')->get();
        return responseApi(true,'',['questions'=>$questions]);
    }
    public function vendorQuestion(){
        $questions=Question::where('type','vendor')->orWhereNull('type')->get();
        return responseApi(true,'',['questions'=>$questions]);
    }
}
