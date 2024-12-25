@extends(auth()->user()->type . '.layouts.' . auth()->user()->type)
@section('title', 'الاشعارات')
@section('content')
    <!-- <div class="scrl-support">
        <a href="{{ route('tickets.index') }}" class="support">
            <img src="{{ asset('front-assets') }}/img/global/Asset 13@5x.png" alt="">
            الدعم
        </a>
        <div class="shere tog-active">
            <div class="img"><img src="{{ asset('front-assets') }}/img/global/Asset 15@5x.png" alt=""></div>
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
    <section class="height-section">
        <div class="notification_content py-5">
            <div class="container mb-3">
                <div class="d-flex align-items-center justify-content-start">
                    <a href="/" class="btn-icon">
                        <div class="icon">
                            <img src="{{ asset('front-assets') }}/img/global/i-home.png" alt="">
                        </div>
                        الرئيسية
                    </a>
                </div>
            </div>
            <div class="container">
                <h4 class="title mb-3">الإشعارات</h4>
                <ul class="notifications-list list-unstyled">
                    @forelse ($notifications as $item)
                        <li>
                            <div class="notification_holder">
                                <div class="notification_text">
                                    <i class="fa-solid fa-circle-exclamation icon-alert"></i>
                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ $item->link }}" class="mb-0">
                                            <p class="content mb-0">
                                                {!! $item->title !!}
                                            </p>
                                        </a>
                                        <div class="date-notification">
                                            <i class="fas fa-clock"></i>
                                            <span>
                                                {{ $item->created_at }}
                                            </span>
                                            <p class="text-dark my-auto">
                                                تم القراءة
                                            </p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </li>
                    @empty
                    @endforelse
                </ul>
                {{ $notifications->links() }}
            </div>
        </div>
    </section>
@endsection
