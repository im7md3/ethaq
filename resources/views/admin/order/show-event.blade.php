@extends('admin.order.layout')
@section('order-content')
<div class="boxes-order" id="events">
    {{-- -------------------------- Include Attachment Form ---------------- --}}
    @include('components.attach')
    {{-- -------------------------- Display Event ---------------- --}}
    <div class="container">

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
                <p class="date">
                    <span>{{ $event->created_at }}</span>
                </p>
                <div class="text_massage ">
                    <div class="line-text mb-2">
                        {{ $event->content }}
                    </div>
                    <div class="">
                        @foreach ($event->files as $file)
                        <a class="btn-border btn-sm" target="_blank" href="{{ display_file($file->path) }}">
                            مرفق{{ $loop->iteration }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- ----------------------------- ردود العمل ----------------- --}}
        @if($event->kids_count>0)
        @foreach ($event->kids as $kid)
        <x-events.cards :kid="$kid" :user="$user" :order="$order"></x-events.cards>
        @endforeach
        @endif
    </div>

</div>



@push('js')
<script>
    let app = new Vue({
        el: "#events",
        data:{
            type:""
        }
    });

</script>
@endpush
@endsection