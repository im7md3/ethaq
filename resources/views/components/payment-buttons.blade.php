@if(auth()->id()==$invoice->from_id)
<a class="btn-header btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
    aria-expanded="false">
    سداد
</a>
<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <li>
        <form action="{{ route('clickpay.store',$invoice) }}" method="POST">
            @csrf
            <button type="submit" class="btn table_btn btn-sm">ClickPay</button>
        </form>
    </li>
    @if($invoice->TypeInEn=="order")
    <li>
        <form action="{{ route('tamam',$invoice) }}" method="POST">
            @csrf
            <button type="submit" class="btn table_btn btn-sm">تمام</button>
        </form>
    </li>
    @if(setting('tamara_active') and $invoice->total <= 5000) <li>
        <form action="{{ route('tamara',$invoice) }}" method="POST">
            @csrf
            <button type="submit" class="btn table_btn btn-sm">تمارا</button>
        </form>
        </li>
        @endif
        @endif
</ul>
@else
<button class="btn table_btn btn-sm">غير مسددة</button>
@endif