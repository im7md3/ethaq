@extends(auth()->user()->type.'.layouts.'.auth()->user()->type)
@section('title','الملف الشخصي')
@section('content')

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
                        <p class="num">{{ $user->second_judger_orders_count + $user->first_judger_orders_count }}</p>
                        <p class="text-num"> عدد العقود </p>
                    </div>
                    <div class="bar"></div>
                    <div>
                        <p class="num">0</p>
                        <p class="text-num"> الاستشارات
                        </p>
                    </div>
                </div>
                <div class="type">
                    <p>{{ $user->occupation?->name }}</p>
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
