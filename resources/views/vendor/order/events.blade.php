@extends('vendor.order.layout')
@section('order-content')
<div class="boxes-order" id="events">
    {{-- -------------------------- Include Attachment Form ---------------- --}}
    @include('components.attach')
    {{-- -------------------------- Display Event ---------------- --}}
    <div class="container">
        {{-- ------------------------ Add Event Form ---------------------------- --}}
        @if ($order->ShowForms)
        <div class="">
            <h5>الأعمال المنفذة</h5>
            <form action="{{ route('vendor.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <attach-form name='content' id="0" show=true place="إضافة عمل"></attach-form>
            </form>
        </div>
        @endif
    </div>
        {{-- -------------------------- Display Event ---------------- --}}
        <div class="container">
            @foreach ($events as $event)
            {{-- ----------------------- Main Event ----------------------- --}}
            <div class="works_box">
                <div class="image_holder">
                    <a href="">
                        <img src="{{ display_file($event->user->photo) }}" width="70" alt="">
                        <h6 class="name">{{ $event->user->name }}</h6>
                        <p class="job">محامي</p>
                    </a>
                </div>
                <div class="info_text">
                    <div class="num-user">{{ $loop->iteration }}</div>
                    <p class="date">
                        <span>{{ $event->created_at }}</span>
                    </p>
                    <div class="text_massage line-text">
                        العمل منفذ رقم {{ $loop->iteration }}
                    </div>
                    <div class="btn_holder d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('vendor.events.show',[$order->hash_code,$event]) }}" type="submit"
                            class="btn btn-sm btn-show">اطلاع</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        </div>

        @push('js')
        <script>
            let app = new Vue({
        el: "#events",
        data:{
            type:'question'
        }
    });

        </script>
        @endpush
        @endsection
