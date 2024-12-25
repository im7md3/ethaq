<div class="modal fade" id="vendors{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">المحاميين</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المحامي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->vendors as $index => $vendor)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $vendor->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
