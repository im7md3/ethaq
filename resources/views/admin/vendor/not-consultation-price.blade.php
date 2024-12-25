@extends('admin.layouts.admin')
@section('title', 'محاميين غير مسجلين لسعر الاستشارة')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            المستخدمين
        </div>
        <div class="large">
            محاميين غير مسجلين لسعر الاستشارة
        </div>
    </div>
    </nav>
    <div class="section_content content_view">
        <div class="btn-holder mb-2">
            <button class="btn btn-primary">عدد المحاميين: {{ $vendors->count() }}</button>
        </div>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>عمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $vendor->name }}</td>
                        <td><a href="{{ route('admin.vendors.show',$vendor) }}" class="btn btn-purple btn-sm"><i class="fa fa-eye"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $vendors->links() }}
        </div>
    </div>
</section>
@endsection