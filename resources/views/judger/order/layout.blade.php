@extends('judger.layouts.judger')
@section('title',$order->title)
@section('content')

<x-order.header :order='$order'></x-order.header>
<div class="container mt-3">
    <div class="row">
        <x-order.menu :order="$order"></x-order.menu>
        <div class="col-xl-9 pb-5">
            @if($order->ActiveJudger==$user->id)
            @yield('order-content')
            @else
            @if($user->id==$order->first_judger_id)
            <div class="alert alert-danger">لقد مضت المدة</div>
            @else
            <div class="alert alert-danger">لا زال الطلب عند المحكم الأصيل</div>
            @endif
            @endif
        </div>
    </div>
</div>
@include('judger.order.pops')
@endsection