@extends('front.layouts.front')
@section('title','الملف الشخصي')
<!-- Start Header -->
@section('content')
@if(!auth()->check())
<header class="main-header-login position-relative">
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

<section class="py-3 height-section" id="app">
    <div class="container">
        <div class="box-profile">
            <div class="header-box text-center">
                <img src="{{display_file($user->photo)}}" alt="{{ $user->name }}" class="img-user">
                <div class="name-user">
                    {{ $user->name }}
                </div>
                <div class="box-num">
                    <div>
                        <p class="num">{{ $user->vendor_orders_count }}</p>
                        <p class="text-num"> عدد العقود </p>
                    </div>
                    <div class="bar"></div>
                    <div>
                        <p class="num">{{ $user->consulting_vendor_count }}</p>
                        <p class="text-num"> الاستشارات
                        </p>
                    </div>
                </div>
                <x-consultation.evaluation :value="$user->VendorConsultingTotalEvaluate"></x-consultation.evaluation>

                <div class="type">
                    <p>{{ $user->occupation?->name }}</p>
                </div>
                <div class="">
                    <a href="{{ route('createConsultation',$user) }}"
                        class="btn btn-sm btn-warning">طلب استشارة</a>
                    {{-- <a href="{{ route('client.orders.create',['vendor_id'=>$user->id]) }}"
                        class="btn btn-sm btn-info">طلب عقد</a> --}}
                </div>
            </div>
            <div class="content-box">

                <p class="p-content">
                    {!! $user->bio !!}
                </p>

                <div class="info container">
                    <div class="d-flex align-items-start gap-4 justify-content-center">
                        <div class="">
                            <p> رقم الرخصة</p>
                            <h6>
                                {{ $user->HasActiveLicense?$user->license?->name:'لا يوجد' }}
                            </h6>
                            <p></p>
                        </div>
                        <div class="">
                            <p class="mb-2"> عدد سنوات الخبرة</p>
                            <h6>{{ $user->years_of_experience }}</h6>
                            <p></p>
                        </div>
                        <div class="">
                            <p> المؤهل العلمي</p>
                            <h6>{{ $user->qualification?->name }}</h6>
                            <p></p>
                        </div>
                        <div class="">
                            <p> التخصص الأكاديمي</p>
                            <h6>{{ $user->specialty?->name }}</h6>
                            <p></p>
                        </div>
                        <!-- <div class="">
                            <p> المسارات القانونية :
                            </p>
                            <h6>
                                {{ $user->list_departments() }}
                            </h6>
                            <p></p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
