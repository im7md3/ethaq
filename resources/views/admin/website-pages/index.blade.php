@extends('admin.layouts.admin')
@section('title','صفحات الموقع')
@section('content')
<section class="">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
            <li href="" class="breadcrumb-item" aria-current="page">
                صفحات الموقع
            </li>
        </ol>
    </nav>
    <div class="section_content content_view">
        <div class="info_holder d-flex align-items-center gap-2 mb-2">
            <div class="up_element">
                <a href="{{ route('admin.website-pages.create') }}" class="btn btn-primary btn-sm">
                    إضافة
                </a>
            </div>
            <div class="buttons_holder d-flex align-items-center gap-2">
                <button class="btn btn-green btn-sm">مفعله:
                    {{ $websitePages->where('status', 1)->count() }}
                </button>
                <button class="btn btn-danger btn-sm">غير مفعله:
                    {{ $websitePages->where('status', 0)->count() }}
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>رقم</th>
                        <th>العنوان</th>
                        <th>الرابط</th>
                        <th>حالة الصفحة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($websitePages as $page)

                    <tr>
                        <th>{{ $page->id }}</th>
                        <td>{{ $page->title }}</td>
                        <td><a target="_blank" href="{{ route('page.show', $page->slug) }}">
                            {{ route('page.show', $page->slug) }}
                        </a></td>
                        <td>{{ $page->status?'مفعلة':'غير مفعلة' }}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('admin.website-pages.edit',$page->id) }}" class="btn btn-info btn-sm text-white mx-1"> <i class="fa-solid fa-pen"></i></a>
                            {{-- <a href="{{ route('admin.website-pages.show',$page->id) }}" class="btn btn-success btn-sm text-white mx-1"> <i class="fa-solid fa-eye"></i></a> --}}
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $page->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.website-pages.delete-modal',['page'=>$page])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $websitePages->links() }}
        </div>
    </div>
</section>
@endsection
