@extends('admin.layouts.admin')
@section('title', 'طلبات تفعيل الأعضاء')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                المستخدمين
            </div>
            <div class="large">
                طلبات تفعيل الأعضاء
            </div>
        </div>
        <div class="section_content content_view">
            <h3>التراخيص والسجلات</h3>
            <div class="table-responsive">
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الجوال</th>
                            <th>الإيميل</th>
                            <th>نوع العضوية</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ __($user->type) }}</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('admin.'.$user->type.'s.show', $user->id) }}"
                                        class="btn btn-purple btn-sm"> <i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $vendors->appends(request()->query())->links() }}
            </div>

            <h3>المؤهلات</h3>
            <div class="table-responsive">
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الجوال</th>
                            <th>الإيميل</th>
                            <th>نوع العضوية</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($advisors as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>مستشار</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('admin.advisors.show', $user->id) }}"
                                        class="btn btn-purple btn-sm"> <i class="fa-solid fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $advisors->appends(request()->query())->links() }}
            </div>
        </div>
    </section>
@endsection
