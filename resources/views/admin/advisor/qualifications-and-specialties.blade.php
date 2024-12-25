@extends('admin.layouts.admin')
@section('title', 'احصائيات المستشارين حسب التخصص والمؤهل')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            المستخدمين
        </div>
        <div class="large">
            احصائيات المستشارين حسب التخصص والمؤهل
        </div>
    </div>
    </nav>
    <div class="section_content content_view">
        <h5>احصائيات التخصص</h3>
        <div class="table-responsive">
            <table class="main-table mb-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>عدد المستشارين</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($specialties as $specialty)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $specialty->name }}</td>
                        <td><a href="{{ route('admin.vendors.index',['specialty'=>$specialty->id]) }}">{{ $specialty->users_count }} <i class="fa fa-eye"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <h5>احصائيات المؤهل</h5>
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>عدد المستشارين</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($qualifications as $qualification)
                    <tr>
                        <td>{{ $loop->iteration }}</th>
                        <td>{{ $qualification->name }}</td>
                        <td><a href="{{ route('admin.vendors.index',['qualification'=>$qualification->id]) }}">{{ $qualification->users_count }} <i class="fa fa-eye"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection