@extends('front.layouts.front')
@section('title','اتصل بنا')
<!-- Start Header -->
@section('content')
@if(!auth()->check())
<header class="main-header-login">
    <div
        class="container py-2 text-start d-flex align-items-center gap-4 justify-content-center justify-content-md-between">
        <div class="group-logo d-flex align-items-center justify-content-between ">
            <a href="/">
                <img class="head-logo" src="{{asset('front-assets')}}/img/global/ethaq-logo.png" alt="" srcset="" />
            </a>
            <div class="tog-home tog-active" data-active=".group-login">
                <span class="one-bar"></span>
                <span class="two-bar"></span>
                <span class="three-bar"></span>
            </div>
        </div>

        <div class="group-login d-flex align-items-center justify-content-between flex-fill gap-4">
            <ul class="list-item">
                <li>
                    <a href="#landing" class="item active">الرئيسية</a>
                </li>
                <li>
                    <a href="#questions-page" class="item">كيف تعمل منصتنا</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="item">تواصل معنا</a>
                </li>
            </ul>
            <div class=" group-btn  d-flex align-items-center  gap-3">
                <div class="dropdown">
                    <a class="btn-header btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        إنشاء عضوية
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('client.register') }}">تسجيل عميل</a></li>
                        <li><a class="dropdown-item"
                                href="{{ setting('register_by_nafath')?route('register.nafath'):route('vendor.register') }}">تسجيل
                                محامي</a></li>
                    </ul>
                </div>
                <a href="{{ route('login') }}" class="btn-header btn btn-two"> تسجيل الدخول </a>
            </div>
        </div>
    </div>
</header>
@else
@include(auth()->user()->type.'.layouts.head')
@include(auth()->user()->type.'.layouts.header')
@endif

<!-- End Header -->
<section class="contact py-5">
    <div class="container">

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <h5 class="mb-4 fw-bold main-color">
            أتصل بنا
            <i class="fas fa-phone"></i>
        </h5>
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <img class="img-contact img-fluid mx-auto mb-3" src="{{asset('front-assets')}}/img/home/email.png"
                    alt="contact-image">
                    <div class="d-flex flex-column gap-3">
                        <a href="tel:+920002479"class="item-phone">
                        <i class="icon fas fa-phone"></i>
                        920002479
                        </a>
                        <a href="https://wa.me/+966540477525" class="item-phone">
                        <i class="icon fab fa-whatsapp"></i>
                        966540477525
                        </a>
                        <a href="mailto:info@ethaq.com.sa" class="item-phone">
                        <i class="icon fas fa-envelope"></i>
                        info@ethaq.com.sa
                        </a>
                    </div>
            </div>
            <div class="col-md-6">
                <form action="{{ route('contactUs.store') }}" method="POST">
                    @csrf
                    <div class="row ">
                        <div class="col-12 mb-3">
                            <label for="" class="d-block mb-1">الأسم<em class="text-danger">*</em></label>
                            <input type="text" class="form-control main-inp rounded-1" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="d-block mb-1">الهاتف<em class="text-danger">*</em></label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="form-control main-inp rounded-1">
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="d-block mb-1">الأيميل<em class="text-danger">*</em></label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control main-inp rounded-1">
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="d-block mb-1">عنوان الرسالة<em class="text-danger">*</em></label>
                            <input type="text" name="subject" value="{{ old('subject') }}"
                                class="form-control main-inp rounded-1">
                            @error('subject')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12  mb-3">
                            <label for="" class="d-block mb-1">رسالتك<em class="text-danger">*</em></label>
                            <textarea name="message" id=""
                                class="form-control area-height1 main-inp rounded-1">{{ old('message') }}</textarea>
                            @error('message')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {!! NoCaptcha::renderJs() !!}
                        {!! NoCaptcha::display() !!}
                        @error('g-recaptcha-response')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        <div class="col-12 text-center mt-3 ">
                            <button type="submit" class="btn btn-sm px-4 btn-green">ارسال</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Start Footer -->


@endsection


