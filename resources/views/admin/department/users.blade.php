@extends('admin.layouts.admin')
@section('title', 'الأعضاء المشتركين في القسم '.$department->name)
@section('content')
<section class="">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                الأعضاء المشتركين في القسم {{  $department->name}}
            </li>
        </ol>
    </nav>
    <div class="section_content content_view">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>حالة الاتصال</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td><i
                            class="fa-solid fa-circle state_offline {{ Cache::has('user-is-online-' . $user->id) ? 'text-success' : 'text-secondary' }}"></i></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</section>
@endsection
