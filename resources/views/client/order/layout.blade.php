@extends('client.layouts.client')
@section('title',$order->title)
@section('content')
<x-order.header :order='$order'></x-order.header>
<div class="container mt-3">
    <div class="row">
        
        <x-order.menu :order="$order"></x-order.menu>
        <div class="col-xl-9 pb-5">
            @yield('order-content')
        </div>
    </div>
@include('client.order.pops')

</div>

@endsection