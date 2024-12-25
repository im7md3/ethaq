@extends('admin.layouts.admin')
@section('title', 'استشارة رقم ' . $con->id)
@section('content')
<section class="pt-5">
    {{-- ------------------- Con Data ---------------- --}}
    <div class="box-chat">
        <div class="d-flex mb-2 align-items-center justify-content-between gap-1">
            <div class="d-flex main-color align-items-center gap-2">
                <div class="cr"></div>
                <small>
                    الاستشارة رقم
                </small>
                <small>
                    {{ $con->id }}
                </small>
            </div>
            <small>
                {{ $con->created_at }}
            </small>
        </div>
        <div class="d-flex align-items-start justify-content-between">
            <div class="d-flex mb-2  gap-2">
                <img src="{{ display_file($con->client->photo) }}" alt="" class="user-img">
                <div>
                    <div class="name">
                        {{ $con->client->name }}
                    </div>
                    <!--
                                <small class="d-block">
                                    الحالة:
                                    <span class="sec-color ">
                                        {{ __($con->status) }}
                                    </span>
                                </small> -->
                    <small class="d-block">
                        النوع:
                        <span class="sec-color">
                            {{ $con->department->name }}
                        </span>
                    </small>
                </div>
            </div>
            <div class="btn-icon-cr not btn-gradient-blue btn cursor-context">
                {{ __($con->status) }}
            </div>
        </div>
        <div class="">
            <div class="line-text mb-2">
                {{ $con->details }}
            </div>
        </div>
        <div class="d-flex align-items-center mt-2 box-btn flex-column gap-2 mx-auto">
            <div class="d-flex flex-wrap w-100 align-items-center gap-2 justify-content-center">
                @forelse ($con->files as $file)
                <a class="btn-border btn-sm" target="_blank" href="{{ display_file($file->path) }}">
                    مرفق{{ $loop->iteration }}</a>
                @empty
                <div class="btn-files">
                    لا يوجد مرفقات
                    <i class="fas fa-file"></i>
                </div>
                @endforelse

            </div>
            <div class="btn-chat flex-column  red-color">
                <small class="fw-normal">
                    {{ $con->PayMessage }}
                </small>
            </div>
        </div>
    </div>
    <div class="section_content content_view">

        {{-- ------------------- Messages ---------------- --}}
        <div class="box-send mt-1 position-relative">
            <div class="box-msg ">
                <div class="d-flex gap-3 flex-column p-3 ">
                    @foreach ($con->messages as $msg)
                    <div class="msg">
                        <div class="info-user d-flex align-items-center gap-2 mb-1">
                            <img src="{{ display_file($msg->fromUser->photo) }}" class="photo">
                            <span class="name">{{ $msg->fromUser->name }}</span>
                            <span class="date ">{{ $msg->human_date }} - {{ $msg->created_at }}</span>
                        </div>
                        @if ($msg->msg)
                        <p class="content-msg">
                            <span>
                                {{ $msg->msg }}
                            </span>
                        </p>
                        @endif
                        <div class="d-flex flex-column gap-1 mt-1">
                            <div class="files d-flex align-items-center gap-1 w-100 ">
                                @foreach ($msg->files as $file)
                                <a class="btn-border btn-sm" target="_blank" href="{{ display_file($file->path) }}"
                                    download="">
                                    <span>مرفق{{ $loop->iteration }} </span>
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection