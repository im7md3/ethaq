@extends('client.layouts.client')
@section('title', 'الخدمات الخاصة | إنشاء خدمة خاصة جديدة')
@section('content')
    <!-- Start Profile User -->
    <section class="">
        <div class="header-content-box  mt-3">
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
                    <div class="title">إنشاء خدمة جديدة</div>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <form action="{{ route('client.specialServices.store') }}" method="post" enctype="multipart/form-data">
                <div class="row row-gap-24">
                    @csrf
                    <div class="col-lg-6">
                        <label for="" class="mb-1">عنوان الخدمة</label>
                        <input type="text" class="main-inp" name="title" value="{{ old('title') }}" />
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="mb-1">المرفقات</label>
                        <input type="file" class="main-inp" name="images[]" multiple />
                    </div>
                    <div class="col-12">
                        <label for="" class="mb-1"> تفاصيل الخدمة </label>
                        <textarea name="details" class="main-inp" id="" cols="30" rows="8" style="height: 300px ">{{ old('details') }}</textarea>
                    </div>
                    <div class="col-12 mt-3 d-flex justify-content-end">
                        <input class="inp-sub" type="submit" value="اضافة خدمة جديدة">
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection
