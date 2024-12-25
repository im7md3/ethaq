@extends('admin.layouts.admin')
@section('title', 'الأعضاء')
@section('content')
<section class="">
        <div class="main-title">
            <div class="small">
                المستخدمين
            </div>
            <div class="large">
            المحكمين
            </div>
        </div>
    <div class="section_content content_view">
        <div class="info_holder d-flex align-items-center gap-2 mb-2">
            <div class="up_element">
                <a href="{{ route('admin.judgers.create') }}" class="btn btn-primary">
                    إضافة
                </a>
            </div>
            <a href="{{ route('admin.judgers.index') }}" class="btn btn-primary">الكل {{ $all }}</a>
            <a href="{{ route('admin.judgers.index',['status'=>'active']) }}" class="btn btn-green">محكمين مفعلين: {{
                $active }}</a>
             <a href="{{ route('admin.judgers.index', ['status'=>'not-active']) }}" class="btn btn-danger">محكمين غير
                مفعلين: {{ $not_active }}</a>
            <form action="{{ route('admin.judgers.index') }}" method="get" style="display: inline-block">
                <input type="text" name="search" value="{{ request()->search }}" placeholder="بحث .....">
                <button type="submit" class="btn btn-info">
                    بحث
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="main-table">
                <thead >
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>المدينة</th>
                        <th>نوع العضوية</th>
                        <th>حالة الاتصال</th>

                        @can('activate_users')
                        <th>ايقاف</th>
                        @endcan
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->city?->name }}</td>
                        <td>{{ __($user->type) }}</td>
                        <td><i
                            class="fa-solid fa-circle state_offline {{ Cache::has('user-is-online-' . $user->id) ? 'text-success' : 'text-secondary' }}"></i></td>
                        @can('activate_users')
                        <td class="text-center">
                            <form action="{{ route('admin.users.block', $user->id) }}" method="post">
                                @csrf
                                <div class="form-check form-switch d-flex">
                                    <input class="form-check-input" type="checkbox" {{ $user->is_block ? 'checked' : ''
                                    }} onclick="this.form.submit();"
                                    name="is_block" role="switch" id="flexSwitchCheckDefault">
                                </div>

                            </form>
                        </td>
                        @endcan
                        <td class="d-flex gap-2">
                            @can('update_users')
                            <a href="{{ route('admin.judgers.edit', $user->id) }}"
                                class="btn btn-info btn-sm text-white mx-1"> <i class="fa-solid fa-pen"></i></a>
                            @endcan
                            @can('read_users')
                            <a href="{{ route('admin.judgers.show', $user->id) }}"
                                class="btn btn-success btn-sm text-white mx-1"> <i class="fa-solid fa-eye"></i></a>
                            @endcan
                            @can('delete_users')
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $user->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            @include('admin.judger.delete-modal', ['user' => $user])
                            @endcan
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</section>
@endsection
