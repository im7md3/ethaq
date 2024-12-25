@extends('admin.layouts.admin')
@section('title', 'التحويلات البنكية')
@section('content')
<section class="">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                التحويلات البنكية
            </li>
        </ol>
    </nav>
    <div class="section_content content_view">
        <div class="">
            <a href="?status=" class="btn btn-info btn-sm">الكل: {{ $all }}</a>
            <a href="?status=pending" class="btn btn-warning btn-sm">جديدة: {{ $pending }}</a>
            <a href="?status=accepted" class="btn btn-success btn-sm">مقبولة: {{ $completed }}</a>
            <a href="?status=rejected" class="btn btn-danger btn-sm">مرفوضة: {{ $refused }}</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>العميل</th>
                        <th>اسم المحول</th>
                        <th>اسم البنك</th>
                        <th>رقم الحساب</th>
                        <th>المبلغ</th>
                        <th>الصورة</th>
                        <th>الوقت</th>
                        <th>الحالة</th>
                        <th>تحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banks as $bank)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td><a href="{{ route('admin.'.$bank->user->type.'s.show',$bank->user) }}">{{ $bank->user->name }}</a></td>
                        <td>{{ $bank->transfer_name }}</td>
                        <td>{{ $bank->bank_name }}</td>
                        <td>{{ $bank->account_no }}</td>
                        <td>{{ $bank->invoice->total }}</td>
                        <td>
                            <a target="_blank" class="btn btn-sm btn-info" href="{{ display_file($bank->file) }}">الملف</a>
                        </td>
                        <td>{{ $bank->created_at->diffForHumans() }}</td>
                        <td>{{ __($bank->status) }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="{{ route('admin.bankTransfers.show',$bank) }}">عرض التفاصيل</a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $banks->links() }}
        </div>
    </div>
</section>
@endsection
