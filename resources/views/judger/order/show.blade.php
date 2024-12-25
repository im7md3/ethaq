@extends('judger.order.layout')
@section('order-content')
<section>
    {{-- ************************ Order Card **************************** --}}
    <div class="boxes-order" id="client">
        <x-order.card-client :order="$order" :user="$user"></x-order.card-client>
        {{-- ************************ Accepted Offer Card **************************** --}}
        <x-offer.card :offer="$order->activeOffer" :order="$order"></x-offer.card>
        {{-- ****************** Messages between client and vendor ********************* --}}
        @if($order->objection_id)
        @foreach ($order->activeNegotiation->messages as $message)
        <x-negotiation.card :message="$message"></x-negotiation.card>
        @endforeach
        @endif
    </div>

</section>

@endsection