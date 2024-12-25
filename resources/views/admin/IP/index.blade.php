@extends('admin.layouts.admin')
@section('title',$title)
@section('content')
<section class="">
    <div class="main-title">
        <div class="small">
            Ip's
        </div>
        <div class="large">
            {{ $title }}
        </div>
    </div>
    <div class="section_content content_view">
        @include('admin.IP.delete-all-modal')
        <div class="mb-2">
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-all">حذف الكل
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>IP</th>
                        <th>الدولة</th>
                        <th>الجهاز</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ips as $ip)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $ip->ip }}</td>
                        <td>{{ $ip->country }}</td>
                        <td>{{ $ip->device }}</td>

                        <td class="d-flex gap-2">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#delete{{ $ip->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            @include('admin.IP.delete-modal', [
                            'ip' => $ip,
                            ])
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $ips->links() }}
        </div>
    </div>
</section>
@endsection