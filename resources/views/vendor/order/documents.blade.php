@extends('vendor.order.layout')
@section('order-content')
<div class="boxes-order" id="documents">
    <div class="mb-2">
        <h6 class="blue-color m-0 fw-bold">حصر المتطلبات والمستندات الاساسية للأعمال مطلوب تنفيذها</h6>
        <div class="line-text mb-2">
            {{ $order->activeOffer->documents }}
        </div>
    </div>
    {{-- ************************ Messages Card **************************** --}}
    @forelse ($documents as $document)
    <x-order-documents.card :document="$document" :order="$order"></x-order-documents.card>
    {{ $documents->links() }}
    @empty
    <div class="alert alert-danger">لا يوجد أي مستند</div>
    @endforelse
    {{-- ************************* Negotiation Form ********************** --}}
    {{-- @if (!$order->objection_id)
    @include('components.attach')
    <form action="{{ route('vendor.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <attach-form name='msg' id="0" show=true place="إضافة مستند"></attach-form>
    </form>
    @endif --}}
</div>
@push('js')
<script>
    let app = new Vue({
        el: "#documents",
        data:{
        }
    });

</script>
@endpush
@endsection
