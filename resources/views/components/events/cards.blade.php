<div class="chat-box {{ $kid->user->id==auth()->id()?'':'vendor' }}">
    <div class="img-holder">
        <img class="photo" src="{{ display_file($kid->user->photo) }}" alt="" width="25" />
    </div>
    <div class="holder-content d-flex flex-column">
        <div class="info d-flex flex-wrap align-items-start justify-content-between">
            <div class="per-info d-flex flex-column align-items-start gap-1">
                <div class="per-name d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-circle active"></i>
                    <p class="name mb-0">{{ $kid->user->type=='client'?$kid->user->username:$kid->user->name }}</p>
                </div>
                <div class="type d-flex align-items-center justify-content-center gap-1">
                    <i class="fa-solid fa-user"></i>
                    <h6 class="type-name main-color mb-0">{{ $kid->user->type=='client'?'عميل':'محامي' }}</h6>
                </div>
            </div>
            <div class="header-box d-flex justify-content-between gap-2">
                <div class="item d-flex align-items-center gap-1">
                    <i class="fa-regular fa-clock"></i>
                    {{ $kid->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        <div class="content">
            <div class="content-order line-text">
                {{ $kid->content }}
            </div>
            <div class="mt-3">
                <x-attachments :files="$kid->files" :voices="$kid->voices"></x-attachments>
                
            </div>
        </div>
    </div>
</div>
@foreach ($kid->kids as $son)
{{-- <div class="chat-box {{ $son->user->id==auth()->id()?'':'vendor' }}">
    <div class="img-holder">
        <img class="photo" src="{{ display_file($son->user->photo) }}" alt="" width="25" />
    </div>
    <div class="holder-content d-flex flex-column">
        <div class="info d-flex flex-wrap align-items-start justify-content-between">
            <div class="per-info d-flex flex-column align-items-start gap-1">
                <div class="per-name d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-circle active"></i>
                    <p class="name mb-0">{{ $son->user->name }}</p>
                </div>
                <div class="type d-flex align-items-center justify-content-center gap-1">
                    <i class="fa-solid fa-user"></i>
                    <h6 class="type-name main-color mb-0">{{ $son->user->type=='client'?'عميل':'محامي' }}</h6>
                </div>
            </div>
            <div class="header-box d-flex justify-content-between gap-2">
                <div class="item d-flex align-items-center gap-1">
                    <i class="fa-regular fa-clock"></i>
                    {{ $son->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        <div class="content">
            <div class="content-order line-text">
                {{ $son->content }}
            </div>
            <div class="mt-3">
                @foreach ($son->files as $file)
                <a class="btn-border btn-sm" target="_blank" href="{{ display_file($file->path) }}">
                    مرفق{{ $loop->iteration }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div> --}}
@endforeach

{{-- تصميم الاعمال القديم, ممنوع الحذف ممكن نحتاجه --}}
{{-- <div class="conversation_box">
    <div class="container">
        <div class="type_box">
            <div class="btn_holder">
                <button class="btn {{$kid->type=='question'?'btn_Inquiry':'btn_objection'  }} btn-sm">{{
                    $kid->type=='question'?'استفسار':'اعتراض' }}</button>
            </div>
            <div class="massage_box">
                <div class="num-user">
                    {{ $kid-> }}
                </div>
                <p class="date">
                    <span>{{ $kid->created_at }}</span>
                </p>
                <div class="text">{{ $kid->content }}</div>
                <div class="">
                    @foreach ($kid->files as $file)
                    <a class="btn-border btn-sm" target="_blank" href="{{ display_file($file->path) }}">
                        مرفق{{ $loop->iteration }}</a>
                    @endforeach
                </div>
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
                <div class="">
                    @foreach ($son->files as $file)
                    <a class="btn-border btn-sm" target="_blank" href="{{ display_file($file->path) }}">
                        مرفق{{ $loop->iteration }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div> --}}
