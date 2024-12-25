@extends(auth()->user()->type . '.layouts.' . auth()->user()->type)
@section('title', 'التذاكر')
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
    <!-- Start Tickets -->
    <section class="">
        <div class="container">
            <div class="app">

                <div class="app-content">
                    <div class="header-content-box">
                        <div class="container">
                            <div class=" d-flex align-items-center gap-2">
                                <a href="/" class="btn-icon justify-content-between">
                                    <div class="icon">
                                        <img src="{{ asset('front-assets') }}/img/global/i-home.png" alt="">
                                    </div>
                                </a>
                                <div class="title">
                                    <i class="fa-solid fa-angles-left"></i>
                                </div>
                                <div class="title">
                                    التذاكر
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container py-5">
                        <div class="d-flex align-items-center flex-wrap gap-3 justify-content-between">
                            <div class="btn-icon-cr">
                                لديك {{ $tickets->count() }} تذكرة
                                <div class="lg-badge ">
                                    {{ $tickets->count() }}
                                </div>
                            </div>
                            <a href="{{ route('tickets.create') }}" class="btn-icon-cr">
                                إنشاء تذكرة جديدة
                                <div class="icon">
                                    <img src="{{ asset('front-assets') }}/img/global/Asset 2.svg" alt="">
                                </div>
                            </a>
                        </div>
                        @foreach ($tickets as $ticket)
                            <div class="box-tickets d-flex flex-column gap-3 mt-5">
                                <div class="ticket">
                                    <div class="date">
                                        <i class="fas fa-calendar-days"></i>
                                        {{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}
                                    </div>
                                    <p class="text">{{ $ticket->title }}</p>
                                    <div class="d-flex align-items-center gap-2">

                                        @if ($ticket->status == 'open')
                                            <span class="badge bg-warning">مفتوحة</span>
                                        @elseif($ticket->status == 'finished')
                                            <span class="badge bg-success">تم الرد</span>
                                        @else
                                            <span class="badge bg-danger">مغلقة</span>
                                        @endif
                                        @if ($ticket->comments->where('read_at', null)->first())
                                            <span class="badge bg-danger">رساله جديدة</span>
                                        @endif
                                        <a href="{{ route('tickets.show', encrypt($ticket->id)) }}"
                                            class="btn-icon-cr  btn-gradient-blue btn">
                                            عرض
                                            <i class="fas fa-long-arrow-alt-left"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Tickets -->

@endsection
