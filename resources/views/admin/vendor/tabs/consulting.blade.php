<div class="tab-pane fade" id="nav-consulting">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th colspan="2">الأقسام المشترك بها</th>
                    <td colspan="2">
                        @foreach ($user->consultingDepartments as $dep)
                        {{ $dep->name }},
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th colspan="2">سعر الاستشارة</th>
                    <td colspan="2">
                        <span>{{ $user->consulting_price }}</span>
                    </td>
                </tr>
                <tr>
                    <th colspan="2">الاستشارات المجانية</th>
                    <td colspan="2">
                        <span>{{ $user->free_consulting ? 'مفعلة' : 'غير مفعلة' }}</span>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>