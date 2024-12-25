@extends('admin.layouts.admin')
@section('title', 'احصائية العملاء')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            الرئيسية
        </div>
        <div class="large">
            احصائية العملاء
        </div>
    </div>
    <div class="section_content content_view">
        <div class="">
            <form action="">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}">
                <button class="btn btn-sm btn-info">بحث</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>رقم</th>
                        <th>الاسم</th>
                        <th>رقم الجوال</th>
                        <th>عدد الاستشارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ route('admin.clients.show',$user) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->phone }}</td>
                        <td><a href="{{ route('admin.consulting.index',['client_id'=>$user->id]) }}">{{ $user->consulting_client_count }} <i class="fa fa-eye"></i></a></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</section>
@endsection