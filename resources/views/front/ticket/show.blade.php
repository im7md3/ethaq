@extends(auth()->user()->type . '.layouts.' . auth()->user()->type)

@section('title')
    التذاكر | {{ $ticket->title }}
@endsection

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
                    <div class="title">{{ $ticket->title }}</div>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <div class="boxes-order">
                <div class="box-order">

                    <div class="content">
                        <div class="header-box">
                            <div class="item">
                                تذكرة رقم : <span class="count">{{ $ticket->id }}</span>

                            </div>
                            <div class="item">
                                <i class="fa-solid fa-calendar-day"></i>
                                {{ $ticket->created_at->isoFormat('D-MM-Y') }}
                            </div>

                            <div class="item">
                                <i class="fa-solid fa-calendar-days"></i>
                                {{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}
                            </div>

                            <div class="item">
                                @if ($ticket->status == 'open')
                                    <span class="badge bg-warning">مفتوحة</span>
                                @elseif($ticket->status == 'finished')
                                    <span class="badge bg-success">تم الرد</span>
                                @else
                                    <span class="badge bg-danger">مغلقة</span>
                                @endif
                            </div>

                        </div>
                        <div class="hr my-3"></div>
                        <h5 class="title-order">
                            {{ $ticket->title }}
                        </h5>
                        <div class="content-order line-text">
                            {{ $ticket->description }}
                        </div>

                    </div>
                </div>

                @if ($ticket->comments->count() > 0)
                    <div class="comments">
                        @foreach ($ticket->comments as $comment)
                            <div class="box-order mb-2">
                                <div class="content">
                                    <h5 class="title-order d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        {{ $comment->user->name }}
                                        <span class="text-color-dark text-fs-1">
                                            {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }} - {{ $comment->created_at->isoFormat('D-MM-Y') }}
                                        </span>
                                    </h5>
                                    <div class="break my-3"></div>
                                    <div class="content-order line-text">
                                        {{ $comment->comment }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
            <div class="box-send">
                <div class="parent-form-add my-3">
                    <form action="{{ route('tickets.storeComment', $ticket->id) }}" method="post">
                        @csrf
                        <div class="d-flex">
                            <div class="par-texarea">
                                <textarea class="" placeholder="اكتب تعليقك هنا " maxlength="2000" name="comment" oninput="countText()"></textarea>
                                <div class="count-area position-absolute" id="Inquiry-count">2000 / 0</div>
                            </div>
                            <button type="submit" class="group-send  bg-transparent border-0">
                                <img src="{{ asset('front-assets') }}/img/global/telegram.png" alt="">
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </section>
    <!-- Start Profile User -->
@endsection
