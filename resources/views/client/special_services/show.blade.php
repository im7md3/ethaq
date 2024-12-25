@extends('client.layouts.client')
@section('title',$specialService->title)
@section('content')
<section class="section-chat" id="service">
    @include('components.attach')
<div class="header-content-box mt-3">
            <div class="container">
                <div class="d-flex align-items-center gap-2">
                    <a href="/" class="btn-icon justify-content-between">
                        <div class="icon">
                            <img src="{{ asset('front-assets') }}/img/global/i-home.png" alt="">
                        </div>
                    </a>
                    <div class="title">
                        <i class="fa-solid fa-angles-left"></i>
                    </div>
                    <div class="title">عرض خدمة خاصة</div>
                </div>
            </div>
        </div>
    <div class="container">
        <div class="app">
            <div class="boxes-order mb-5">
                <div class="box-order">
                    <div class="content">
                        <h5 class="title-order">
                            {{ $specialService->title }}
                        </h5>
                        <div class="content-order line-text">
                            {{ $specialService->details }}
                        </div>
                        <x-attachments :files="$specialService->files"
                            :voices="$specialService->voices"></x-attachments>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class=" box-send mt-1 position-relative  ">
                    <div class="box-msg">
                        {{-- --------------------------------- Messages --------------------------- --}}
                        <div class="d-flex gap-3 flex-column p-3 ">
                            @foreach($specialService->messages as $msg)
                            <div class="msg {{ auth()->id()==$msg->user_id?'':'from' }}">
                                <div class="info-user d-flex align-items-center gap-2 mb-1">
                                    <span class="name">{{ $msg->user?->name }}</span>
                                    <span class="date ">{{ $msg->created_at }}</span>
                                </div>
                                <p class="content-msg">
                                    <span>{{ $msg->content }}</span>
                                </p>
                                <!-- Img -->
                                <x-attachments :files="$msg->files" :voices="$msg->voices"></x-attachments>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- --------------------------------- Form for Messages --------------------------- --}}
                <form action="{{ route('client.specialServices.msg',$specialService) }}" method="post"
                    enctype="multipart/form-data" class="form_content ">
                    @csrf
                    <attach-form name='content' id="1" show=true></attach-form>
                </form>
            </div>
        </div>
    </div>
</section>
@push('js')

<script>
    var boxMsg = document.querySelector(".box-msg");
                boxMsg.scrollTo(0,boxMsg.scrollHeight);
                window.scrollTo(0,document.body.scrollHeight);
</script>
<script>
    let app = new Vue({
    el: "#service",
});

</script>
@endpush
@endsection
