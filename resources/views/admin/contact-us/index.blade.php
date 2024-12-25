@extends('admin.layouts.admin')
@section('title', 'اتصل بنا | وارد')
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            الرئيسية
        </div>
        <div class="large">
            اتصل بنا | وارد
        </div>
    </div>
    <div class="">
        <a href="?status=" class="btn btn-info btn-sm">الكل: {{ $all }}</a>
        <a href="?status=closed" class="btn btn-warning btn-sm">بإنتظار الرد: {{ $pending }}</a>
        <a href="?status=finished" class="btn btn-success btn-sm">تم الرد: {{ $finished }}</a>
    </div>
    <div class="section_content content_view">
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>واتسآب</th>
                        <th>الايميل</th>
                        <th>العنوان</th>
                        <th>الوقت</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contactuses as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            <a href="https://wa.me/00966{{ substr($item->phone, 1) }}" target="_blank" class="btn-whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </td>
                        <td><a href="mailto:{{ $item->email }}">{{ $item->email }}</a></td>
                        <td>{{ $item->subject }}</td>
                        <td>{{ $item->created_at }}</td>

                        <td>
                            @can('read_contact')
                            <a class="btn btn-purple btn-sm" data-bs-toggle="modal"
                                data-bs-target="#show{{ $item->id }}">
                                <i class="fa fa-eye"></i>
                            </a>
                            @include('admin.contact-us.show-modal', ['item' => $item])
                            @endcan
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit{{ $item->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            @can('delete_contact')
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $item->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.contact-us.delete-modal', [
                            'item' => $item,
                            ])
                            @endcan
                            @include('admin.contact-us.edit-modal', [
                            'item' => $item,
                            ])
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $contactuses->links() }}
        </div>
    </div>
</section>
@endsection