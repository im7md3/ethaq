@extends('admin.layouts.admin')
@section('title', 'الأعضاء')
@section('content')
    <section class="">
        <div class="main-title">
            <div class="small">
                المستخدمين
            </div>
            <div class="large">
                الأعضاء
            </div>
        </div>
        <div class="section_content content_view">
            <div class="info_holder d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
                <div class="btn-holder d-flex align-items-center flex-wrap gap-1">
                    <a href="{{ route('admin.clients.create') }}" class="main-btn btn-main-color">
                        إضافة
                        <i class="fa-solid fa-plus"></i>
                    </a>
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-primary">الكل: {{ $all }}</a>
                    <a href="{{ route('admin.clients.index', ['status' => 'active']) }}" class="btn btn-green">اعضاء مفعلين:
                        {{ $active }}</a>
                    <a href="{{ route('admin.clients.index', ['status' => 'not-active']) }}" class="btn btn-danger">اعضاء
                        غير
                        مفعلين: {{ $not_active }}</a>
                    <a href="{{ route('admin.clients.index', ['delete' => 'true']) }}" class="btn btn-danger">حذف الحساب:
                        {{ $delete }}</a>
                </div>
                <a href="{{ route('admin.clients.exports', request()->query()) }}" class="btn btn-info">تصدير<i
                        class="fa-solid fa-file-export"></i></a>
                <form action="{{ route('admin.clients.index') }}" method="get" class="box-search">
                    <img src="{{ asset('admin-assets/img/search.png') }}" alt="icon">
                    <input type="search" name="search" value="{{ request()->search }}" placeholder="بحث...">
                    <button type="submit" class="main-btn btn-main-color d-inline" style="padding: 3px 10px;">
                        بحث
                    </button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="main-table mb-2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الجوال</th>
                            <th>المدينة</th>
                            <th>نوع العضوية</th>
                            <th>حالة الاتصال</th>
                            <th>الواتساب</th>
                            @can('activate_users')
                                <th>ايقاف</th>
                            @endcan
                            <th>حذف الحساب</th>
                            <th>آخر دخول</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-nowrap">{{ $user->name }}</td>
                                <td class="text-nowrap">{{ $user->phone }}</td>
                                <td class="text-nowrap">{{ $user->city?->name }}</td>
                                <td class="text-nowrap">{{ __($user->type) }}</td>
                                <td>
                                    <i
                                        class="fa-solid fa-circle state_offline {{ Cache::has('user-is-online-' . $user->id) ? 'text-success' : 'text-secondary' }}"></i>
                                </td>
                                <td>
                                    <a href="https://wa.me/00966{{ substr($user->phone, 1) }}" target="_blank"
                                        class="btn-whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </td>
                                @can('activate_users')
                                    <td class="text-center ">
                                        <form action="{{ route('admin.users.block', $user->id) }}" method="post">
                                            @csrf
                                            <div class="form-check form-switch d-flex">
                                                <input class="form-check-input" type="checkbox"
                                                    {{ $user->is_block ? 'checked' : '' }} onclick="this.form.submit();"
                                                    name="is_block" role="switch" id="flexSwitchCheckDefault">
                                            </div>
                                        </form>
                                    </td>
                                @endcan
                                <td class="text-nowrap">{{ $user->delete_date ? 'نعم' : 'لا' }}</td>
                                <td class="text-nowrap">{{ $user->last_seen_text }}</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('admin.orders.index', ['client_id' => $user->id]) }}"
                                        class="btn-light-blue text-nowrap">الطلبات: {{ $user->client_orders_count }}</a>
                                    <a href="{{ route('admin.consulting.index', ['client_id' => $user->id]) }}"
                                        class="btn-light-green text-nowrap">الاستشارات:
                                        {{ $user->consulting_client_count }}</a>
                                    @can('update_users')
                                        <a href="{{ route('admin.clients.edit', $user->id) }}" class="btn btn-info btn-sm"> <i
                                                class="fa-solid fa-pen"></i></a>
                                    @endcan
                                    @can('read_users')
                                        <a href="{{ route('admin.clients.show', $user->id) }}" class="btn btn-purple btn-sm">
                                            <i class="fa-solid fa-eye"></i></a>
                                    @endcan
                                    @can('delete_users')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $user->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        @include('admin.client.delete-modal', ['user' => $user])
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
