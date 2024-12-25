<div class="chat-box {{ $message->user->id==auth()->id()?'':'vendor' }}">
    <div class="img-holder">
        <img class="photo" src="{{ display_file($message->user->photo) }}" alt="" width="25" />
    </div>
    <div class="holder-content d-flex flex-column">
        <div class="info d-flex flex-wrap align-items-start justify-content-between">
            <div class="per-info d-flex flex-column align-items-start gap-1">
                <div class="per-name d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-circle active"></i>
                    <p class="name mb-0">{{ $message->user->type=='client'?$message->user->username:$message->user->name }}</p>
                </div>
                <div class="type d-flex align-items-center justify-content-center gap-1">
                    <i class="fa-solid fa-user"></i>
                    <h6 class="type-name main-color mb-0">{{ $message->user->type=='client'?'عميل':'محامي' }}</h6>
                </div>
            </div>
            <div class="header-box d-flex justify-content-between gap-2">
                <div class="btn_blue alt_main">استفسار</div>
                <div class="item d-flex align-items-center gap-1">
                <i class="fa-regular fa-clock"></i>
                    {{ $message->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        <div class="content">
            <div class="content-order line-text">
                {{ $message->msg }}
            </div>
            <div class="mt-3">
                <x-attachments :files="$message->files" :voices="$message->voices??[]"></x-attachments>
            </div>
        </div>
    </div>
</div>
