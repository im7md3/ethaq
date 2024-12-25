@extends('client.layouts.client')
@section('title', 'الخدمات الخاصة')
@section('content')
<section class="">
    <div class="container">
        <div class="app">
                <div class="app-content">
                    <div class="container">
                        <h5 class="mb-4">الخدمات الخاصة</h5>
                        <div class="d-flex justify-content-end mb-2">
                        <a href="{{ route('client.specialServices.create') }}" class="btn btn-sm btn-primary">إضافة خدمة جديدة</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-n-border sm table-striped table-bordered">
                                <thead>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>العنوان</th>
                                    <th>الوقت</th>
                                    <th>تحكم</th>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td><a href="{{ route('admin.clients.show',$service->client) }}">{{
                                                $service->client->name }}</a></td>
                                        <td>{{ $service->title }}</td>
                                        <td>{{ $service->created_at->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info"
                                                href="{{ route('client.specialServices.show',$service) }}">عرض</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $services->links() }}
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>
@endsection
