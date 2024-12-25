@extends('admin.layouts.admin')
@section('title','الرئيسية')
@section('content')
<div class="main-title">
    <div class="small">
        الرئيسية
    </div>
    <div class="large">
        لوحة التحكم
    </div>
</div>
<!-- <div class="status_section mb-3">
    <div class="row g-2">
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="status_box blue-box">
                <div class="data">
                    <h3>{{ App\Models\Order::count() }}</h3>
                    <p class="mb-3">كل الطلبات</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-chart-column blue-icon"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="more">
                    <i class="fa-solid fa-circle-arrow-right"></i>
                    المزيد من المعلومات
                </a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="status_box success-box">
                <div class="data">
                    <h3>{{ App\Models\User::clients()->count() }}</h3>
                    <p class="mb-3">كل الاعضاء</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-people-roof success-icon"></i>
                </div>
                <a href="{{ route('admin.clients.index') }}" class="more">
                    <i class="fa-solid fa-circle-arrow-right"></i>
                    المزيد من المعلومات
                </a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="status_box danger-box">
                <div class="data">
                    <h3>{{ App\Models\User::vendors()->count() }}</h3>
                    <p class="mb-3">كل المحامين</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-user-shield danger-icon"></i>
                </div>
                <a href="{{ route('admin.vendors.index') }}" class="more">
                    <i class="fa-solid fa-circle-arrow-right"></i>
                    المزيد من المعلومات
                </a>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="status_box warning-box">
                <div class="data">
                    <h3>
                        {{ App\Models\User::judgers()->count() }}
                    </h3>
                    <p class="mb-3">كل المحكمين</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-users-line warning-icon"></i>
                </div>
                <a href="{{ route('admin.judgers.index') }}" class="more">
                    <i class="fa-solid fa-circle-arrow-right"></i>
                    المزيد من المعلومات
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row row-gap-24 mb-4 boxes-info">
    <div class=" col-sm-6 col-lg-3">
        <div class="box-info blue">
            <i class="fas fa-coins bg-icon"></i>
            <div class="num">0.00
            </div>
            <div class="text"> المالية</div>
        </div>
    </div>
    <div class=" col-sm-6 col-lg-3">
        <div class="box-info green">
            <i class="fas fa-money-check-alt bg-icon"></i>
            <div class="num">
                {{ App\Models\Withdrawal::sum('amount') }}
            </div>
            <div class="text"> طلبات السحب
            </div>
        </div>
    </div>
    <div class=" col-sm-6 col-lg-3">
        <div class="box-info red">
            <i class="fas fa-credit-card bg-icon"></i>
            <div class="num">
                {{ App\Models\SuspendedBalance::sum('amount') }}
            </div>
            <div class="text"> طلبات المالية المعلقة
            </div>
        </div>
    </div>
    <div class=" col-sm-6 col-lg-3">
        <div class="box-info pur">
            <i class="fas fa-file-signature bg-icon"></i>
            <div class="num">0.00
            </div>
            <div class="text">عقود التوثيق </div>
        </div>
    </div>
    <div class=" col-sm-6 col-lg-3">
        <div class="box-info green">
            <i class="fas fa-user-check bg-icon"></i>
            <div class="num">{{ App\Models\User::whereHas('license', function ($q) {
                $q->where('status', 'pending');
                })
                ->orWhereHas('commercial', function ($q) {
                $q->where('status', 'pending');
                })
                ->count(); }}
            </div>
            <div class="text">طلبات تفعيل الاعضاء</div>
        </div>
    </div>
    <div class=" col-sm-6 col-lg-3">
        <div class="box-info pur">
            <i class="fas fa-sheet-plastic bg-icon"></i>
            <div class="num">{{ App\Models\User::whereHas('license', function ($q) {
                $q->where('status', 'pending');
                })
                ->orWhereHas('commercial', function ($q) {
                $q->where('status', 'pending');
                })
                ->count(); }}
            </div>
            <div class="text">تراخيص وسجلات بالإنتظار</div>
        </div>
    </div>
    <div class=" col-sm-6 col-lg-3">
        <div class="box-info blue">
            <i class="fas fa-ticket bg-icon"></i>
            <div class="num">{{ App\Models\Ticket::count() }}
            </div>
            <div class="text">تذاكر الدعم الفني</div>
        </div>
    </div>
    <div class=" col-sm-6 col-lg-3">
        <div class="box-info red">
            <i class="fas fa-phone bg-icon"></i>
            <div class="num">{{ App\Models\ContactUs::count() }}</div>
            <div class="text">اتصل بنا</div>
        </div>
    </div>
</div> -->
<div class="row g-4 mb-5">
    <div class="col-6 col-md-4 col-xl-3">
        <div class="box-data box-blue">
            <div class="bar-name">
                <h5 class="name">العملاء</h5>
                <div class="box-icon">
                    <img src="{{ asset('admin-assets/img') }}/icons/user-groub.png" alt="icon">
                </div>
            </div>
            <h4 class="amount">{{ App\Models\User::clients()->count() }}</h4>
            <a href="{{ route('admin.clients.index') }}" class="more">
                المزيد من المعلومات
                <img src="{{ asset('admin-assets/img') }}/icons/arrow.svg" alt="arrow icon">
            </a>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-3">
        <div class="box-data box-orange">
            <div class="bar-name">
                <h5 class="name">المحامين</h5>
                <div class="box-icon">
                    <img src="{{ asset('admin-assets/img') }}/icons/work-bag.png" alt="icon">
                </div>
            </div>
            <h4 class="amount">{{ App\Models\User::vendors()->count() }}</h4>
            <a href="{{ route('admin.vendors.index') }}" class="more">
                المزيد من المعلومات
                <img src="{{ asset('admin-assets/img') }}/icons/arrow.svg" alt="arrow icon">
            </a>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-3">
        <div class="box-data box-green">
            <div class="bar-name">
                <h5 class="name">الطلبات</h5>
                <div class="box-icon">
                    <img src="{{ asset('admin-assets/img') }}/icons/user-file.png" alt="icon">
                </div>
            </div>
            <h4 class="amount">{{ App\Models\Order::count() }}</h4>
            <a href="{{ route('admin.orders.index') }}" class="more">
                المزيد من المعلومات
                <img src="{{ asset('admin-assets/img') }}/icons/arrow.svg" alt="arrow icon">
            </a>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-3">
        <div class="box-data box-purple">
            <div class="bar-name">
                <h5 class="name">الاستشارات</h5>
                <div class="box-icon">
                    <img src="{{ asset('admin-assets/img') }}/icons/contract-white.svg" alt="icon">
                </div>
            </div>
            <h4 class="amount">{{ App\Models\Consulting::count() }}</h4>
            <a href="{{ route('admin.consulting.index') }}" class="more">
                المزيد من المعلومات
                <img src="{{ asset('admin-assets/img') }}/icons/arrow.svg" alt="arrow icon">
            </a>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-12 col-lg-6">
        <div class="box-content-white">
            <div class="box-header">
                <div class="option-circle">
                    <div class="circle">
                        <span></span>
                        <p>الطلبات</p>
                    </div>
                    <div class="circle">
                        <span></span>
                        <p>الاستشارات</p>
                    </div>
                </div>
                <select name="" id="" class="gray-select form-select">
                    <option value="">أسبوع</option>
                </select>
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <canvas id="waveChart" class="w-100 h-100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 d-flex align-items-center">
        <div class="row g-4">
        <div class="col-12">
                <div class="box-data box-yellow">
                    <div class="bar-name">
                        <h5 class="name">المستشارين</h5>
                        <div class="box-icon">
                        <img src="{{ asset('admin-assets/img') }}/icons/user-groub.png" alt="icon">
                        </div>
                    </div>
                    <h4 class="amount">{{ App\Models\User::advisors()->count() }}</h4>
                    <a href="{{ route('admin.advisors.index') }}" class="more">
                        المزيد من المعلومات
                        <img src="{{ asset('admin-assets/img') }}/icons/arrow.svg" alt="arrow icon">
                    </a>
                </div>
            </div>
        <div class="col-12 col-md-6">
                <div class="box-data box-red">
                    <div class="bar-name">
                        <h5 class="name">المستخدمين المحذوفين</h5>
                        <div class="box-icon">
                        <img src="{{ asset('admin-assets/img') }}/icons/user-groub.png" alt="icon">
                        </div>
                    </div>
                    <h4 class="amount">{{ App\Models\User::AllDeleted()->count() }}</h4>
                    <a href="{{ route('admin.deletedUsers') }}" class="more">
                        المزيد من المعلومات
                        <img src="{{ asset('admin-assets/img') }}/icons/arrow.svg" alt="arrow icon">
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="box-data box-main-color">
                    <div class="bar-name">
                        <h5 class="name">طلبات السحب</h5>
                        <div class="box-icon">
                            <img src="{{ asset('admin-assets/img') }}/icons/doller.png" alt="icon">
                        </div>
                    </div>
                    <h4 class="amount">{{ App\Models\Withdrawal::count() }}</h4>
                    <a href="{{ route('admin.withdrawals.index') }}" class="more">
                        المزيد من المعلومات
                        <img src="{{ asset('admin-assets/img') }}/icons/arrow.svg" alt="arrow icon">
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="box-data box-main-color">
                    <div class="bar-name">
                        <h5 class="name">الدعم الفني</h5>
                        <div class="box-icon">
                            <img src="{{ asset('admin-assets/img') }}/icons/sppourt.png" alt="icon">
                        </div>
                    </div>
                    <h4 class="amount">{{ App\Models\Ticket::count() }}</h4>
                    <a href="{{ route('admin.tickets.index') }}" class="more">
                        المزيد من المعلومات
                        <img src="{{ asset('admin-assets/img') }}/icons/arrow.svg" alt="arrow icon">
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="box-data box-main-color">
                    <div class="bar-name">
                        <h5 class="name">اتصل بنا</h5>
                        <div class="box-icon">
                            <img src="{{ asset('admin-assets/img') }}/icons/call.png" alt="icon">
                        </div>
                    </div>
                    <h4 class="amount">{{ App\Models\ContactUs::count() }}</h4>
                    <a href="{{ route('admin.contact-us.index') }}" class="more">
                        المزيد من المعلومات
                        <img src="{{ asset('admin-assets/img') }}/icons/arrow.svg" alt="arrow icon">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Wave Chart
    if (document.getElementById('waveChart')) {
        const ctx = document.getElementById('waveChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                        label: '',
                        data: [120, 190, 30, 50, 20, 30],
                        borderWidth: 1,
                        borderColor: '#8D1EE5',
                        backgroundColor: '#8D1EE5',
                    },
                    {
                        label: '',
                        data: [12, 40, 100, 20, 40, 10],
                        borderWidth: 1,
                        borderColor: '#0FC859',
                        backgroundColor: '#0FC859',
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    intersect: false,
                },
                scales: {
                    x: {
                        display: true,
                    },
                    y: {
                        display: true,
                        suggestedMin: 0,
                        suggestedMax: 200
                    }
                }
            },
        });
    }
</script>
@endpush
@stop
