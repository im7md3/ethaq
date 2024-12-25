<div class="chat-box {{ $document->user->id==auth()->id()?'':'vendor' }}">
    <div class="img-holder">
        <img class="photo" src="{{ display_file($document->user->photo) }}" alt="" width="25" />
    </div>
    <div class="holder-content d-flex flex-column">
        <div class="info d-flex flex-wrap align-items-start justify-content-between">
            <div class="per-info d-flex flex-column align-items-start gap-1">
                <div class="per-name d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-circle active"></i>
                    <p class="name mb-0">{{ $document->user->username }}</p>
                </div>
                <div class="type d-flex align-items-center justify-content-center gap-1">
                    <i class="fa-solid fa-user"></i>
                    <h6 class="type-name main-color mb-0">{{ $document->user->type=='client'?'عميل':'محامي' }}</h6>
                </div>
            </div>
            <div class="header-box d-flex justify-content-between gap-2">
                <div class="item d-flex align-items-center gap-1">
                <i class="fa-regular fa-clock"></i>
                    {{ $document->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        <div class="content">
            <div class="content-order line-text">
                {{ $document->msg }}
            </div>
            <div class="mt-3">
                <x-attachments :files="$document->files" :voices="$document->voices"></x-attachments>
            </div>
        </div>
    </div>
</div>
