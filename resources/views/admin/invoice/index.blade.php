@extends('admin.layouts.admin')
@section('title', 'الفواتير')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            الرئيسية
        </div>
        <div class="large">
            الفواتير
        </div>
    </div>
    <div class="section_content content_view">
        <div class="buttons_holder d-flex align-items-center justify-content-start flex-wrap gap-1 mb-2">
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-primary">الكل:
                5</a>
            <a href="{{ route('admin.invoices.index',['status' => 'pending']) }}" class="btn btn-warning text-white">بالانتظار:
                5</a>
            <a href="{{ route('admin.invoices.index',['status' => 'ongoing']) }}" class="btn btn-green">تحت التنفيذ:
                5</a>
            <a href="{{ route('admin.invoices.index',['status' => 'done']) }}" class="btn btn-secondary">منتهية:
                5</a>
            <a href="{{ route('admin.invoices.index',['status' => 'close']) }}" class="btn btn-danger">ملغية:
                5</a>
            <a href="{{ route('admin.invoices.index',['status' => 'unpaid']) }}" class="btn btn-purple">غير مدفوعة:
                5</a>
            <a href="" class="btn btn-purple">مدفوعة لاحقا: 5</a>
            <a href="" class="btn btn-info">تصدير<i class="fa-solid fa-file-export"></i></a>
        </div>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>رقم</th>
                        <th>القسم</th>
                        <th>حالة الاستشارة</th>
                        <th>العميل</th>
                        <th>المحامي</th>
                        <th>مدفوعة لاحقا</th>
                        <th>المبلغ</th>
                        <th>حالة الدفع</th>
                        <th>الوقت المستهلك</th>
                        <th>التاريخ</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td class="d-flex gap-1">
                            <a target="_blank" href="" class="btn btn-purple btn-sm"> معاينة</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</section>
<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف استشارة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    @csrf
                    هل أنت متأكد من حذف الفاتورة
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">نعم</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
