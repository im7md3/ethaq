<!-- Pdf -->
<div class="files w-100 mb-2 ">
    @foreach ($files as $file)
    @if($file->type=='pdf')
    <a class="btn-border btn-sm" target="_blank" href="{{ display_file($file->path) }}" download="">
        <span>مرفق </span>
        <i class="fas fa-file-pdf"></i>
    </a>
    @endif
    @endforeach
</div>
<!-- Audio -->
<div class="d-flex flex-column w-100 gap-1 mb-2">
    @isset($voices)
    @foreach ($voices as $file)
    @if($file->type=='audio')
    <audio class="w-100" src="{{ display_file($file->path) }}" controls="controls">
        <source src="{{ display_file($file->path) }}" type="audio/mpeg">
    </audio>
    @endif
    @endforeach
    @endisset

</div>
<!-- video -->
<div class="d-flex flex-column w-100 gap-1 mb-2">
    @foreach ($files as $file)
    @if($file->type=='video')
    <video class="w-50" src="{{ display_file($file->path) }}" controls="controls">
        <source src="{{ display_file($file->path) }}" type="audio/mpeg">
    </video>
    @endif
    @endforeach
</div>
<!-- Img -->
<div class="box-show-imgs">
    @foreach ($files as $file)
    @if($file->type=='img')
    <a class="" target="_blank" href="{{ display_file($file->path) }}">
        <img src="{{ display_file($file->path) }}" class="img" alt="">
    </a>
    @endif
    @endforeach

</div>