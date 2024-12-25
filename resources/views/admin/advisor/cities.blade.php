@extends('admin.layouts.admin')
@section('title', 'احصائيات المستشارين حسب المدينة')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            المستخدمين
        </div>
        <div class="large">
            احصائيات المستشارين حسب المدينة
        </div>
    </div>
    <div class="section_content content_view">
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>عدد المحاميين</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cities as $city)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $city->name }}</td>
                        <td><a href="{{ route('admin.vendors.index',['city'=>$city->id]) }}">{{ $city->users_count }} <i class="fa fa-eye"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $cities->links() }}
        </div>
    </div>
</section>
@endsection