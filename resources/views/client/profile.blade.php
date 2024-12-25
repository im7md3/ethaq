@extends('client.layouts.client')
@section('title','الرئيسية')
@section('content')
<section class="">
    <div class="container">
        <div class="row  g-xxl-5 app">
            @include('client.layouts.sidebar')

            <div class="col-lg-9">
                <div class="app-content">
                    <h5 class="mb-4">
                        إنشاء طلب جديد
                    </h5>
                    <div class="boxes-order-dep under-line-before row g-3 row-cols-2 row-cols-md-4 row-cols-xxl-5">
                        <div class="col">
                            <a href="{{ route('client.consulting.create') }}">
                                <div class="box active">
                                    <img src="{{ asset('admin-assets/img') }}/icons/add.svg" alt="" class="icon" />
                                    استشارة قانونية
                                </div>
                            </a>
                        </div>
                        @foreach (App\Models\Department::ParentsWithoutConsultings()->get() as $department)
                        <div class="col">
                            <a href="{{ route('client.orders.create',['dep_id'=>$department->id]) }}"
                                class="box">
                                <img src="{{ asset('front-assets/img') }}/global/dep2.svg" alt="" class="icon" />
                                {{ $department->name }}
                            </a>
                        </div>
                        @endforeach

                    </div>

                    <div class="icon-text d-block d-lg-none mt-5 mb-5">
                        <div class="icon">
                            <img src="{{ asset('front-assets/img/global/item-btn-3.svg') }}" alt="">
                        </div>
                        حلقة الوصل بين العميل والمحامي
                    </div>

                    <h5 class="fw-bold mb-4">
                        استشارات/طلبات حديثة
                    </h5>
                    <div class="boxes-new-orders">
                        @foreach ($orders as $order)
                        <div class="box">
                            <div class="data">
                                <div class="user">
                                    <img src="{{ asset('front-assets\img\user.png') }}" alt="" class="img">
                                    <div class="text">
                                        <div class="name">{{ $order->client->name }}</div>
                                        {{-- <div class="dep">التخصص</div> --}}
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="title">عنوان الطلب</div>
                                    <div class="cont">{{ $order->title }}</div>
                                </div>
                            </div>
                            <div class="control">
                                <div class="btns">
                                    <span class="badge-info text-fs-1">{{ __($order->status) }}</span>
                                    <a href="{{ route($user->type.'.orders.show',$order->hash_code) }}" class="btn-box">
                                        <i class="fas fa-angle-left"></i>
                                    </a>
                                </div>
                                <div class="date">{{ $order->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection