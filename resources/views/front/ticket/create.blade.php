@extends(auth()->user()->type . '.layouts.' . auth()->user()->type)
@section('title', 'التذاكر | إنشاء تذكرة جديدة')
@section('content')
<!-- <div class="scrl-support">
    <a href="{{route('tickets.index')}}" class="support">
        <img src="{{asset('front-assets')}}/img/global/Asset 13@5x.png" alt="">
        الدعم
    </a>
    <div class="shere tog-active">
        <div class="img"><img src="{{asset('front-assets')}}/img/global/Asset 15@5x.png" alt=""></div>
        <div class="shere-list">
            <a href="#" class="shere-item">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="shere-item">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="shere-item">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="shere-item">
            <i class="fas fa-envelope"></i>
            </a>
        </div>
    </div>
</div> -->
    <!-- Start Profile User -->
    <section class="height-section">
        <div class="header-content-box">
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
                    <div class="title">إنشاء تذكرة جديدة</div>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <form action="{{ route('tickets.store') }}" method="post">

                <div class="row row-gap-24">
                    @csrf

                    <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">

                    <div class="col-lg-6">
                        <label for="" class="mb-1">عنوان التذكرة</label>
                        <input type="text" class="main-inp" name="title" value="{{ old('title') }}" />
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="mb-1">اختر النوع</label>
                        <div class="box-inp">
                            <select class="inp" name="type" id="">
                                <option value="">اختر النوع</option>
                                <option value="orders" {{ old('type') == 'orders' ? 'selected' : '' }}>الطلبات</option>
                                <option value="activate_mempership"
                                    {{ old('type') == 'activate_mempership' ? 'selected' : '' }}>تفعيل العضوية</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>آخرى</option>
                            </select>
                            <div class="icon">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="" class="mb-1"> الوصف </label>
                        <textarea name="description" class="main-inp" id="" cols="30" rows="8" style="height: 300px ">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-12 mt-3 d-flex justify-content-end">
                        <input class="inp-sub" type="submit" value="اضافة تذكرة جديدة">
                    </div>

                </div>
            </form>

        </div>
    </section>
    <!-- Start Profile User -->

@endsection
