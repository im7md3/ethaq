<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'order_type', 'order_id', 'content'];
    public static function suspension($user, $order, $amount)
    {
        $order_id = $order->id;
        $order_type = get_class($order);
        if ($order_type  == 'App\Models\Order') {
            $content = 'تم تعليق مبلغ مقداره ' . $amount . ' للطلب ' . $order->title;
        } else {
            $content = 'تم تعليق مبلغ مقداره ' . $amount . ' للاستشارة ' . $order_id;
        }
        $user_id = $user->id;
        static::query()->create(compact('user_id', 'order_id','order_type', 'content'));
    }

    public static function transfer($user, $order, $amount)
    {
        $order_id = $order->id;
        $order_type = get_class($order);
        if ($order_type == 'App\Models\Order') {
            $content = 'تم تحويل مبلغ مقداره ' . $amount . 'ريال سعودي من الطلب ' . $order->title;
        } else {
            $content = 'تم تحويل مبلغ مقداره ' . $amount . ' ريال سعودي من الاستشارة ' . $order_id;
        }
        $user_id = $user->id;
        static::query()->create(compact('user_id', 'order_id','order_type', 'content'));
    }

    public static function withdrawal($user_id, $amount)
    {
        $content = 'تم طلب سحب مبلغ مقداره ' . $amount;
        static::query()->create(compact('user_id', 'content'));
    }

    public static function withdrawalComplete($user_id, $amount)
    {
        $content = 'تم سحب مبلغ مقداره ' . $amount . ' بنجاح';
        static::query()->create(compact('user_id', 'content'));
    }

    public static function withdrawalRefused($user_id, $amount)
    {
        $content = 'تم رفض سحب مبلغ مقداره ' . $amount;
        static::query()->create(compact('user_id', 'content'));
    }

    public static function refundComplete($user_id, $amount)
    {
        $content = 'تم استرجاع مبلغ مقداره ' . $amount . ' بنجاح';
        static::query()->create(compact('user_id', 'content'));
    }
    public static function refundRefused($user_id, $amount)
    {
        $content = 'تم رفض استرجاع مبلغ مقداره ' . $amount;
        static::query()->create(compact('user_id', 'content'));
    }
}
