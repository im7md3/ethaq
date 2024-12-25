@extends('client.order.layout')
@section('order-content')
<div class="boxes-order">
{{-- ************************ Offers Card **************************** --}}
@forelse ($offers as $offer)
        <x-offer.card :offer="$offer" :order="$order"></x-offer.card>
        @empty
        <div class="alert alert-danger">لا يوجد عروض مقدمة من قبل المحامي</div>
    @endforelse
</div>

@endsection