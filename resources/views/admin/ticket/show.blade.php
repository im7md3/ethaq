@extends('admin.layouts.admin')
@section('title', 'التذاكر')


@push('css')
<style>
    ul.timeline {
        list-style-type: none;
        padding: 0 !important;
        margin: 0 !important;
        position: relative;
    }

    ul.timeline:before {
        content: ' ';
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 10px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }

    ul.timeline>li {
        margin: 1rem 0 1rem 25px;
    }

    ul.timeline>li:before {
        content: ' ';
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #22c0e8;
        left: 1px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }
    .box-order.comment-box {
        background: #ddd;
        border-radius: 3px;
        border-color: #ddd;
    }
    .box-order.comment-box .item {
        color: #444;
    }
    .box-order.comment-box .hr {
        background: #bbb;
    }
    .box-order.comment-box .title-order {
        color: black;
    }
    .box-order.comment-box .content-order {
        color: black;
    }
    .box-order.comment-box.admin {
        background: #4A6E99;
        border-color: #4A6E99;
    }
    .box-order.comment-box.admin .item {
        color: #eee;
    }
    .box-order.comment-box.admin .hr {
        background: #bbb;
    }
    .box-order.comment-box.admin .title-order {
        color: white;
    }
    .box-order.comment-box.admin .content-order {
        color: white;
    }
</style>
@endpush

@section('content')
<section class="">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                التذاكر
            </li>
        </ol>
    </nav>

    <a href="{{ route('admin.tickets.index') }}" class="mb-3 btn btn-primary">عودة للتذاكر</a>
    <div class="section_content content_view">

        <div class="box-order mb-4">
            <div class="content">
                <div class="header-box">
                    <div class="item">
                        <i class="fa-solid fa-calendar-days"></i>
                        {{ $ticket->created_at->isoFormat('D-MM-Y') }}
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
        <h5>
            التعليقات:
        </h5>
        <ul class="timeline ">
            @if ($ticket->comments->count() > 0)
            @foreach ($ticket->comments as $comment)
            <li>
            <div class="box-order comment-box mb-4 {{ $comment->user_id!=$ticket->user_id?'admin':'' }}">
            <div class="content">
                <div class="header-box">
                    <div class="item">
                        <i class="fa-solid fa-calendar-days"></i>
                        {{
                    \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }} - {{
                    $comment->created_at->isoFormat('D-MM-Y') }}
                    </div>
                </div>
                <div class="hr my-3"></div>
                <h5 class="title-order">
                {{ $comment->user?->name??'مستخدم محذوف' }}
                </h5>
                <div class="content-order line-text">
                {{ $comment->comment }}
                </div>
            </div>
        </div>
            </li>
            @endforeach
            @endif

        </ul>


        <div class="card">
            <div class="card-header">
                إضافة تعليق
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tickets.storeComment') }}" method="post">
                    @csrf

                    <input type="hidden" name="user_id" value="1">
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                    <div class="form-group">
                        <textarea name="comment" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="mt-2 btn btn-primary">حفظ</button>
                    </div>


                </form>
            </div>
        </div>



    </div>
</section>
@endsection
