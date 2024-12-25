@extends('admin.layouts.admin')
@section('title', 'طلبات السحب')
@section('content')
<section class="">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                طلبات السحب
            </li>
        </ol>
    </nav>
    <div class="section_content content_view">
        <div class="">
            <a href="?status=" class="btn btn-info btn-sm">الكل: {{ $all }}</a>
            <a href="?status=pending" class="btn btn-warning btn-sm">بالانتظار: {{ $pending }}</a>
            <a href="?status=completed" class="btn btn-success btn-sm">تم السحب: {{ $completed }}</a>
            <a href="?status=refused" class="btn btn-danger btn-sm">مرفوضة: {{ $refused }}</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>المبلغ</th>
                        {{-- <th>شهادة ضريبية</th> --}}
                        {{-- <th>الرقم الضريبي</th> --}}
                        {{-- <th>الصورة</th> --}}
                        <th>الوقت</th>
                        <th>الحالة</th>
                        <th>تحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($withdrawals as $withdrawal)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td><a href="{{ route('admin.'.$withdrawal->user->type.'s.show',$withdrawal->user) }}">{{ $withdrawal->user->name }}</a></td>
                        <td>{{ $withdrawal->amount }}</td>
                        {{-- <td>{{ $withdrawal->tax_certificate?'نعم':'لا' }}</td> --}}
                        {{-- <td>{{ $withdrawal->tax_certificate?$withdrawal->number:'-'}}</td> --}}
                        {{-- <td>@if($withdrawal->tax_certificate)
                            <a target="_blank" class="btn btn-sm btn-info" href="{{ display_file($withdrawal->file) }}">الملف</a>
                            @else
                            -
                            @endif
                        </td> --}}
                        <td>{{ $withdrawal->created_at->diffForHumans() }}</td>
                        <td>{{ __($withdrawal->status) }}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="{{ route('admin.withdrawals.show',$withdrawal) }}">عرض التفاصيل</a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $withdrawals->links() }}
        </div>
    </div>
</section>
@endsection
