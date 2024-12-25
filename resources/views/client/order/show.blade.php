@extends('client.order.layout')
@section('order-content')
<section>
    {{-- ********************** Include Attach File To Use Componnet Vue ****************** --}}
    @include('components.attach')
    {{-- ************************ Order Card **************************** --}}
    <div class="boxes-order" id="client">
        <x-order.card-client :order="$order" :user="$user"></x-order.card-client>

        {{-- ************************ Vendors Offers Card **************************** --}}
        @if ($order->IsReadyToSelectJudgerOrAccept)
        {{-- ************************ Accepted Offer Card **************************** --}}
        <x-offer.card :offer="$order->activeOffer" :order="$order"></x-offer.card>
        {{-- ****************** Messages between client and vendor ********************* --}}
        @foreach ($order->activeNegotiation->messages as $message)
        <x-negotiation.card :message="$message"></x-negotiation.card>
        @endforeach
        {{-- ************************ Negotiation Form **************************** --}}
        @if ($order->ShowForms)
        <x-negotiation.form :order="$order" :user="$user" :negotiation="$order->activeNegotiation??0"></x-negotiation.form>
        @endif
        @else
        {{-- Show offers before accept one of them --}}
        @foreach ($order->accessVendors as $vendor)
        @include('client.order.vendor-offer-card')
        @endforeach
        @endif

    </div>

</section>
@push('js')
<script>
    let app = new Vue({
    el: "#client",
    data:{
        current_form:''
    }
});

</script>
@endpush
@endsection