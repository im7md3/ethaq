<div class="works_box">
    <div class="image_holder">
        <a href="">
            <img src="{{ display_file($event->user->photo) }}" width="70" alt="">
            <h6 class="name">{{ $event->user->name }}</h6>
            <p class="job">محامي</p>
        </a>
    </div>
    <div class="info_text">
    <div class="num-user">1</div>
        <p class="date">
            <span>{{ $event->created_at }}</span>
        </p>
        <div class="text_massage line-text">
            {{ $event->content }}
        </div>
        <div class="btn_holder">
            <button class="btn btn-sm btn-show">اطلاع</button>
            <button class="btn btn-sm btn-show" @click='type="question"'>استفسار</button>
            <button class="btn btn-sm btn-show" @click='type="objection"'>عدم قبول</button>
        </div>
    </div>
</div>
@client
<form action="{{ route('vendor.events.store') }}" method="POST" enctype="multipart/form-data" id="form">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <input type="hidden" name="type" value="{{ $type }}">
    <attach-form name='content' id="3" show=true></attach-form>
</form>
@endclient
@foreach ($event->kids as $kid)
<div class="conversation_box" >
    <div class="container">
        <div class="type_box">
            <div class="btn_holder">
                <button class="btn {{$kid->type=='question'?'btn_Inquiry':'btn_objection'  }} btn-sm">{{ $kid->type=='question'?'استفسار':'اعتراض' }}</button>
            </div>
            <div class="massage_box">
                <p class="date">
                    <span>{{ $kid->created_at }}</span>
                </p>
                <div class="text">{{ $kid->content }}</div>
            </div>
        </div>
        <div class="btn_holder my-3">
            <button class="btn btn-replay btn-sm">ردود على {{ $kid->type=='question'?'الاستفسار':'الاعتراض' }}</button>
        </div>
        @foreach ($kid->kids as $son)
        <div class="{{ $son->user->type=='client'?'replay_box_one':'replay_box_two' }}">
            <p class="name mb-0">{{ $son->user->name }}</p>
            <div class="replay">
                <span class="mb-0">{{ $son->content }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endforeach
