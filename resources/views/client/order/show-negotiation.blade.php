@extends('client.order.layout')
@section('order-content')
<div class="boxes-order" id="negotiations">
  {{-- ************************ Messages Card **************************** --}}
  @forelse ($messages as $message)
  <x-negotiation.card :message="$message" :order="$order"></x-negotiation.card>
  {{ $messages->links() }}
  @empty
  <div class="alert alert-danger">لا يوجد أي استفسار مقدم من قبل المحامي</div>
  @endforelse
  {{-- ************************* Negotiation Form ********************** --}}
  @include('components.attach')
  <x-negotiation.form :order="$order" :user="$user" :negotiation="$negotiation??0"></x-negotiation.form>
</div>
@push('js')
    <script>
        let app = new Vue({
        el: "#negotiations",
        data:{
        }
    });

    </script>
    @endpush 
@endsection