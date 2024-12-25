@extends('vendor.layouts.vendor')
@section('title','الاستشارات')
@section('content')
<section class="">
    <div class="container">
        <div class="row app">
            @include('vendor.layouts.consulting-sidebar')
            <div class="col-lg-9">
                <div class="app-content">
                    <div class="container-flued py-4">
                        <div class="alert alert-success text-center d-lg-none">انت مشترك</div>
                        <h6>الاستشارات</h6>
                        <div class="box-filter mb-3">
                            <a href="{{ route('vendor.consulting.index',['status'=>'pending']) }}" class="filter">
                                <span class="lg-badge sm">{{ $pending_count }}</span>
                                جديدة
                            </a>
                            <a href="{{ route('vendor.consulting.index',['status'=>'active']) }}"
                                class="filter {{ request('status')=='active'?'active':'' }}">
                                <span class="lg-badge sm">{{ $active_count }}</span>
                                نشطة
                            </a>
                            <a href="{{ route('vendor.consulting.index',['status'=>'done']) }}"
                                class="filter {{ request('status')=='done'?'active':'' }}">
                                <span class="lg-badge sm">{{ $done_count }}</span>
                                منتهية
                            </a>
                            <a href="{{ route('vendor.consulting.index',['status'=>'cancel']) }}"
                                class="filter {{ request('status')=='cancel'?'active':'' }}">
                                <span class="lg-badge sm">{{ $cancel_count }}</span>
                                ملغية
                            </a>
                        </div>
                        <div class="row row-gap-24">
                            @foreach ($consulting as $con)
                            <div class="col-lg-6 col-xl-4">
                                <div class="box-consulting">
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
                                            {{$con->created_at}}
                                        </small>
                                    </div>
                                    <div class="d-flex mb-4 justify-content-between gap-1">
                                        <div class="d-flex   gap-2">
                                            <img src="{{ display_file($con->client->photo) }}" alt="" class="user-img">
                                            <div>
                                                <div class="name">
                                                    {{ $con->client->username }}
                                                </div>
                                                <small class="d-block">
                                                    الحالة:
                                                    <span class="sec-color ">
                                                        {{ __($con->status) }}
                                                    </span>
                                                </small>
                                                <small class="d-block">
                                                    النوع:
                                                    <span class="sec-color">
                                                        {{ $con->DepartmentName }}
                                                    </span>
                                                </small>
                                            </div>
                                        </div>
                                        <a href="{{ route('vendor.consulting.show',$con) }}" class="arrow">
                                            <i class="fas fa-angle-left"></i>
                                        </a>
                                    </div>
                                    <a href="{{ route('vendor.consulting.show',$con) }}" class="price mb-2">
                                        <small>
                                            @if ($con->status=='done')
                                            @if($con->free)
                                            منتهية
                                            @else
                                            تم الدفع
                                            @endif
                                            {{-- <div class="d-flex align-item-center justify-content-center gap-2">
                                                <span class="fw-bold">{{ $con->amount }}</span>
                                                <small>ر.س</small>
                                            </div> --}}
                                            @else
                                            {{ __($con->status) }}
                                            @endif
                                        </small>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{ $consulting->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection