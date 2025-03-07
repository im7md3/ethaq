@extends('front.layouts.front')
@section('title','الأسئلة الشائعة')
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
<section id="questions-page" class="questions-page py-5">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between  ">
      <div class="box-one">
        <img src="{{asset('front-assets')}}/img/home/q.png" alt="" />

      </div>

      <div class="box-two">
      <div class="box-title mb-3 mb-md-4">
            <div class="title">
            <span>الأ</span>سئلة الشائعة
            </div>
        </div>
        @foreach($questions as $q )
        <div class="box-collapse">
          <button class="btn-collapse" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseExample{{$q->id}}" aria-expanded="false" aria-controls="collapseExample">
            {{$q->name}}
            <i class="fa-solid fa-angle-down"></i>
          </button>

          <div class="collapse mt-1" id="collapseExample{{$q->id}}">
            {{$q->result }}
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>


@endsection
