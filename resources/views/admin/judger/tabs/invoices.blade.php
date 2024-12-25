<div class="tab-pane fade"  id="nav-invoices">
    <div class="table-responsive">
        <table class="table table-n-border sm table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">رقم</th>
                    <th scope="col">الطلب</th>
                    <th scope="col">قيمة الفاتورة</th>
                    <th scope="col">الضريبة</th>
                    <th scope="col">نسبة الادارة</th>
                    <th scope="col">الاجمالي</th>
                    <th>تسديد</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->order_type=='App\Models\Order'?$invoice->order?->title:'استشارة رقم '.$invoice->order?->id }}</td>
                    <td>{{ $invoice->amount }}</td>
                    <td>{{ $invoice->tax }}</td>
                    <td>{{ $invoice->admin_ratio }}</td>
                    <td>{{ $invoice->total }}</td>
                    <td>
                        @if($invoice->status!='paid')
                        {{-- <form class="d-flex align-items-center gap-1 justify-content-center"
                            action="{{ route('client.invoices.update',$invoice) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" class="btn table_btn btn-sm">سداد</button>
                            <a href="" class="btn table_btn btn-sm"><i class="fa-solid fa-eye"></i></a>
                        </form> --}}
                        <button type="submit" class="btn table_btn btn-sm">غير مسددة</button>
                        @else
                        <button class="btn table_btn btn-sm">تم السداد</button>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
  </div>