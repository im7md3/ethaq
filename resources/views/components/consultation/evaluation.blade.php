<div class="stars" title="{{ $value }}">
    @for ($i = 0; $i < 5; $i++) @if (floor($value) - $i>= 1)
        {{--Full Start--}}
        <i class="star fas fa-star active"></i>
        @elseif ($value - $i > 0)
        {{--Half Start--}}
        <i class="star fa-regular fa-star-half-stroke fa-flip-horizontal active"></i>
        @else
        {{--Empty Start--}}
        <i class="star fa-regular fa-star active"></i>
        @endif
        @endfor
</div>