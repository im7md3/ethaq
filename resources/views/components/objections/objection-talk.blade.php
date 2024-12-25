<div class="tab-pane fade show active" id="tap-1" role="tabpanel">
    <div class="boxes-order">
        @foreach ($order->objectionTalks as $talk)
        <div class="chat-box {{ $talk->user_id!=auth()->id()?'vendor':'' }}">
            <div class="img-holder">
                <img class="photo" src="{{ display_file($talk->user->photo) }}" alt="" width="25">
            </div>
            <div class="holder-content d-flex flex-column">
                <div class="info d-flex flex-wrap align-items-start justify-content-between">
                    <div class="per-info d-flex flex-column align-items-start gap-1">
                        <div class="per-name d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-circle active"></i>
                            <p class="name mb-0">{{ $talk->user->name }}</p>
                        </div>
                        <div class="type d-flex align-items-center justify-content-center gap-1">
                            <i class="fa-solid fa-user"></i>
                            <h6 class="type-name main-color mb-0">{{ __($talk->user->type) }}</h6>
                        </div>
                    </div>
                    <div class="header-box d-flex justify-content-between gap-2">
                        <div class="btn_blue alt_main">استفسار</div>
                        <div class="item d-flex align-items-center gap-1">
                            <i class="fa-regular fa-clock"></i>
                            منذ {{ $talk->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="content-order">
                        <div class="line-text mb-2">
                            {{ $talk->msg }}
                        </div>
                        <div class="">
                            <x-attachments :files="$talk->files" :voices="$talk->voices"></x-attachments>
                        </div>
                    </div>
                    <div class="mt-3">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @if(!$objection->judger_judgment)
        <form action="{{ route($user->type.'.objection_talks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}" id="">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}" id="">
            <input type="hidden" name="objection_id" value="{{ $order->objection_id }}" id="">
            @include('components.attach')
            <attach-form name='msg' id="10" show=true></attach-form>
        </form>
        @endif
    </div>
</div>