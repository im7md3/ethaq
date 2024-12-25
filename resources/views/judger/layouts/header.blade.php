@php
$user = auth()->user();
@endphp
<header class="main-header-login">
    <div class="container py-3 text-start d-flex align-items-center justify-content-center justify-content-md-between">
        <div class="group-logo d-flex flex-fill align-items-center justify-content-between gap-5">
            <a href="/">
                <img class="head-logo" src="{{asset('front-assets')}}/img/global/ethaq-logo.png" alt="" srcset="" />
            </a>
        </div>
            <a href="{{ route('notification') }}" class="item-icon ms-3">
                @if(auth()->user()->unreadNotifications->count()>0)
                <div class="small-badge">
                    {{ auth()->user()->unreadNotifications->count() }}
                </div>
                @endif
                <img src="{{ asset('admin-assets/img') }}/icons/bell.svg" alt="" class="icon" />
            </a>

            <!-- <div class="dropdown menu-header">
                <a href="{{ route('judger.settings') }}" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img class="img-user d-none d-lg-block" src="{{ asset(display_file(auth()->user()->photo)) }}"
                        alt="" />

                    <span class="d-none d-lg-block">{{ auth()->user()->first_name }}</span>
                </a> -->
                <div class="dropdown d-none d-lg-block">
            <button class="dropdown-ellipsis dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="img-user-holder">
                <img class="img-user" src="{{ display_file($user->photo) }}" alt="" />
            </div>
            </button>
            <ul class="dropdown-menu text-end" aria-labelledby="dropdownMenuButton1">
                <li><div class="name">{{ $user->name }}</div></li>
                <li><a class="dropdown-item" href="{{ route('judger.settings') }}">الملف الشخصي</a></li>
                <li><a class="dropdown-item" href="#">
                <form action="{{route('logout')}}" method="post" id="logout-form">
                @csrf
                <button class="bg-transparent">
                تسجيل الخروج
                </button>
            </form>
                </a></li>
            </ul>
            </div>
                <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"
                    class="tog-list d-lg-none  fs-4">
                    <i class="fas fa-bars"></i>
                </a>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                    aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="slide-user">
                            <div class="card-slide">
                                        <img class="img-user" src="{{ display_file($user->photo) }}"
                                            alt="" />
                                <h6 class="">
                                    {{ $user->name }}
                                </h6>
                            </div>

                            <div class="card-slide box-item">
                                <a href="{{ route('judger.settings') }}" class="btn-icon justify-content-between">
                                    ملفي الشخصي
                                    <div class="icon">
                                        <i class="fas fa-angle-left"></i>
                                    </div>
                                </a>
                                <a href="#" class="btn-icon justify-content-between">
                                    الرصيد
                                    <div class="icon">
                                        <i class="fas fa-angle-left"></i>
                                    </div>
                                </a>
                                <a href="" class="btn-icon justify-content-between">
                                    طلبات التنفيذ
                                    <div class="icon">
                                        <i class="fas fa-angle-left"></i>
                                    </div>
                                </a>


                            </div>
                            <div class="card-slide box-item mt-3">
                                <a href="{{route('tickets.index')}}" class="btn-icon justify-content-between">
                                    الدعم الفني
                                    <div class="icon">
                                        <i class="fas fa-angle-left"></i>
                                    </div>
                                </a>
                                <a href="" class="btn-icon justify-content-between">
                                    سياسة الموقع
                                    <div class="icon">
                                        <i class="fas fa-angle-left"></i>
                                    </div>
                                </a>
                                <form action="{{route('logout')}}" method="post" id="logout-form">
                                    @csrf
                                    <button class="btn-icon justify-content-between">
                                        خروج
                                        <div class="icon">
                                            <i class="fas fa-angle-left"></i>
                                        </div>
                                    </button>
                                </form>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <form action="{{route('logout')}}" method="post" id="logout-form">
                @csrf
                <button class="btn-icon">
                    <div class="icon">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </div>
                </button>
            </form> -->
        </div>
    </div>
</header>
<div class="container">


    @if($user->HasActiveLicense)
    @if ($user->license?->status=='pending')
    <div class="alert alert-warning py-2 mb-1 mt-3" role="alert">
        جاري التحقق ومراجعه المستندات والبيانات المطلوبة
        الرجاء الانتظار الى ان يتم تحديث حاله حسابك من قبل الادارة
    </div>
    @endif
    @else
    <div class="alert alert-danger py-2 mt-3" role="alert">
        <a href="{{ route('judger.settings') }}">
            لكي يتم تفعيل كل الخدمات يجيب رفع المستندات والبينات المطلوبة
        </a>
    </div>
    @endif


</div>
