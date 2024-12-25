<?php

namespace Database\Seeders;

use App\Models\AccessVendor;
use App\Models\JudgerOrder;
use App\Models\Negotiation;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderVendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Order::truncate();
        Negotiation::truncate();
        AccessVendor::truncate();
        JudgerOrder::truncate();
        Offer::truncate();
        Order::create([
            'client_id'=>3,
            'vendor_id'=>5,
            'client_id'=>3,
            'department_id'=>5,
            'main_department_id'=>2,
            'offer_id'=>1,
            'negotiation_id'=>1,
            'title'=>'الطلب الاول',
            'details'=>'الطلب الاول الطلب الأول الطلب الاول الطلب الأول',
            'status'=>'ongoing',
            'encrypted'=>false,
            'money_back'=>false,
        ]);
        AccessVendor::create([
            'order_id'=>1,
            'vendor_id'=>5,
        ]);
        Offer::create([
            'order_id'=>1,
            'vendor_id'=>5,
            'amount'=>1000,
            'days'=>5,
            'negotiable'=>false,
            'response_speed'=>'يوم',
            'status'=>'accepted',
            'works'=>'works',
            'documents'=>'documents',
            'execution_method'=>['كتابياً بإرفاق ملف عبر المنصة فقط.'],
            'duration'=>'specified',
        ]);
        Negotiation::create([
            'order_id'=>1,
            'vendor_id'=>5,
        ]);
        JudgerOrder::create([
            'order_id'=>1,
            'judger_id'=>7,
            'type'=>'main',
            'period'=>5,
            'client_decision'=>'pending',
            'judger_decision'=>'pending',
        ]);
        JudgerOrder::create([
            'order_id'=>1,
            'judger_id'=>8,
            'type'=>'sub',
            'period'=>5,
            'client_decision'=>'pending',
            'judger_decision'=>'pending',
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    
}
