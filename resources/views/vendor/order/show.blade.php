@extends('vendor.order.layout')
@section('order-content')
<div class="boxes-order">
    {{-- ********************** Include Attach File To Use Componnet Vue ****************** --}}
    @include('components.attach')
    {{-- ********************** Card order *************************** --}}
    <x-order.card-client :order="$order" :user="$user"></x-order.card-client>

    {{-- ***************** Button for add offer or negotiable *************** --}}
    @if($order->status=="open")
    @include('vendor.order.offer-or-negotiable')
    @endif
    {{-- ************************ My Offers *********************************** --}}
    @foreach ($my_offers as $offer)
    <x-offer.card :offer="$offer" :order="$order"></x-offer.card>
    @endforeach
    {{-- ************************ Messages *********************************** --}}
    @if($user->negotiations->count()>0 and $order->vendor_id)
    @foreach ($user->negotiations[0]->messages as $message)
    <x-negotiation.card :message="$message"></x-negotiation.card>
    @endforeach
    @endif
    {{-- ***************************** Form for negotiation *************************** --}}
    @if($order->IsReadyToSelectJudgerOrAccept and $order->ShowForms) 
    <div class="" id="vendor">
    <x-negotiation.form :order="$order" :user="$user" :negotiation="$order->activeNegotiation??0"></x-negotiation.form>
    </div>
    @push('js')
    <script>
        let app = new Vue({
        el: "#vendor",
        data:{
            dd:''
        }
    });

    </script>
    @endpush
    @endif

</div>

@endsection