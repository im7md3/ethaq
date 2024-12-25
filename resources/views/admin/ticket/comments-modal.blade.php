<div class="modal fade" id="comments{{ $ticket->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">التعليقات - {{ $ticket->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                @if ($ticket->comments->count() > 0)
                    <ul class="timeline">

                        @foreach ($ticket->comments as $comment)
                            <li>
                                <a href="javascript:void(0);">{{ $comment->user?->name??'مستخدم محذوف' }}</a>
                                <a href="javascript:void(0);"
                                    class="float-right">{{ $comment->created_at->isoFormat('D-MM-Y') }}</a>
                                <p>
                                    {{ $comment->comment }}
                                </p>
                            </li>
                        @endforeach

                    </ul>
                @else
                    <div class="alert alert-danger">
                        لا يوجد تعليقات
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@push('css')
    <style>
        ul.timeline {
            list-style-type: none;
            position: relative;
        }

        ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 100%;
            z-index: 400;
        }

        ul.timeline>li {
            margin: 20px 0;
            padding-left: 20px;
        }

        ul.timeline>li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #22c0e8;
            left: 20px;
            width: 20px;
            height: 20px;
            z-index: 400;
        }
    </style>
@endpush
