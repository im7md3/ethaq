@extends('vendor.layouts.vendor')
@section('title', $order->title)
@section('content')

    <x-order.header :order='$order'></x-order.header>
    @if ($order->CanAccessToEncryptedOrder)
        @include('vendor.order.decryption-request')
    @elseif(!$user->canAccessOrder($order->id))
        @include('vendor.order.access')
    @else
        <div class="container mt-3">
            <div class="row">
                <x-order.menu :order="$order"></x-order.menu>
                <div class="col-xl-9 pb-5">
                    @yield('order-content')
                </div>
            </div>
        </div>
        @include('vendor.order.pops')
    @endif

@endsection
