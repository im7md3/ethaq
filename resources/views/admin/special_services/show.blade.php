@extends('admin.layouts.admin')
@section('title',$specialService->title)
@section('content')
<section class="section-chat" id="service">
    @include('components.attach')
    <div class="container">
    <div class="main-title">
            <div class="small">
                الرئيسية
            </div>
            <div class="large">
                عرض خدمة خاصة
            </div>
        </div>
            <div class="app-content">
            <div class="box-order special-ser">
                    <div class="content">
                        <h5 class="title-order">
                            {{ $specialService->title }}
                        </h5>
                        <div class="content-order line-text">
                            {{ $specialService->details }}
                        </div>
                        <x-attachments :files="$specialService->files"></x-attachments>
                    </div>
                </div>
                <div class=" box-send mt-3 position-relative  ">
                    <div class="box-msg box-comment">
                        {{-- --------------------------------- Messages --------------------------- --}}
                        <div class="d-flex gap-3 flex-column p-3 ">
                            @foreach($specialService->messages as $msg)
                            <div class="msg {{ auth()->id()==$msg->user_id?'':'from' }}">
                                    <div class="info-comment mb-3 d-flex align-items-center justify-content-between">
                                        <div class="user">
                                            <img src="https://via.placeholder.com/300" alt="" class="img">
                                            <span class="name">{{ $msg->user?->name }}</span>
                                        </div>
                                        <span class="date ">{{ $msg->created_at }}</span>
                                    </div>
                                <p class="content-comment">
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
                <form action="{{ route('admin.specialServices.msg',$specialService) }}" method="post"
                    enctype="multipart/form-data" class="form_content ">
                    @csrf
                    <attach-form name='content' id="1" show=true></attach-form>
                </form>
            </div>
    </div>
</section>
@push('js')

<script>
    window.addEventListener("load",()=> {
        var boxMsg = document.querySelector(".box-msg");
        boxMsg.scrollTo(0,boxMsg.scrollHeight);
    })
</script>
<script>
    let app = new Vue({
    el: "#service",
});

</script>
@endpush
@endsection
