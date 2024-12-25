@extends('admin.layouts.admin')
@section('title', 'الأعضاء')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            المستخدمين
        </div>
        <div class="large">
            الاعضاء المحذوفين
        </div>
    </div>
    <div class="section_content content_view">
        <div class="d-flex align-items-center flex-wrap gap-1 mb-2 justify-content-end">
            <form action="" method="get" class="box-search">
                <input type="search" name="search" value="" placeholder="بحث .....">
                <button type="submit" class="main-btn btn-main-color d-inline-block" style="padding: 0px 10px;">
                    بحث
                </button>
            </form>
            {{-- <a href="" class="btn btn-info">تصدير<i class="fa-solid fa-file-export"></i></a> --}}
        </div>
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>المدينة</th>
                        <th>العضوية</th>
                        <th>الواتساب</th>
                        <th>كومبليت</th>
                        <th>آخر دخول</th>
                        <th>استعادة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-nowrap">{{ $user->name }}</td>
                        <td class="text-nowrap">{{ $user->phone }}</td>
                        <td class="text-nowrap">{{ $user->city?->name }}</td>
                        <td class="text-nowrap">@if($user->is_advisor)مستشار@else{{ __($user->type) }}@endif</td>
                        <td>
                            <a href="https://wa.me/00966{{substr($user->phone, 1)  }}" target="_blank"
                                class="btn-whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </td>
                        <td class="text-nowrap">{{ __($user->Profilecomplete ? 'yes' : 'no') }}</td>
                        <td class="text-nowrap">{{ $user->last_seen }}</td>
                        <td class="text-nowrap"><button type="button" class="main-btn btn-main-color"
                                data-bs-toggle="modal" data-bs-target="#create{{ $user->id }}">
                                استعادة
                            </button>
                            @include('admin.user.return-modal',['user'=>$user])</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $users->links() }}

    </div>
</section>
@endsection