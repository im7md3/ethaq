@extends(auth()->user()->type.'.layouts.'.auth()->user()->type)
@section('content')
<section class="bg-light-green height-section-footer d-flex align-items-center justify-content-center py-5">
    <div class="container text-center">
        <h1>غير مصرح لك دخول هذه الصفحة</h1>
        <a href="{{ url('/') }}" class="btn btn-primary mt-2">الصفحة الرئيسية</a>
    </div>
</section>
@endsection
