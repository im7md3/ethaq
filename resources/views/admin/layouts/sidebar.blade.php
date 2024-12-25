<div class="sidebar">
    <div class="tog-active d-none d-lg-block" data-tog="true" data-active=".app">
        <i class="fas fa-bars"></i>
    </div>
    <ul class="list">
        <li class="list-item active">
            <a href="{{ url('/') }}">
                <div>
                    <i class="fa-solid fa-grip"></i>
                    الرئيسية
                </div>
            </a>
        </li>
        @can('read_notifications')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#notices" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-bell"></i>
                    الإشعارات الإدارية
                    <div class="main-badge">
                        {{ App\Models\Notification::where(function ($q) {
                        $q->whereRelation('user', 'type', 'admin');
                        })->count() }}
                    </div>
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="notices">
            <li class="list-item">
                <a href="{{ route('admin.admin_notifications') }}">
                    <div>
                        <i class="fa-solid fa-bell"></i>
                        الكل
                        <div class="main-badge">
                            {{ App\Models\Notification::where(function ($q) {
                            $q->whereRelation('user', 'type', 'admin');
                            })->count() }}
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.admin_notifications', ['type' => 'new-client']) }}">
                    <div>
                        <i class="fa-solid fa-bell"></i>
                        عميل جديد
                        <div class="main-badge">
                            {{ App\Models\Notification::where(function ($q) {
                            $q->whereRelation('user', 'type', 'admin');
                            })->where('type', 'new-client')->count() }}
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.admin_notifications', ['type' => 'new-vendor']) }}">
                    <div>
                        <i class="fa-solid fa-bell"></i>
                        مقدم خدمه جديد
                        <div class="main-badge">
                            {{ App\Models\Notification::where(function ($q) {
                            $q->whereRelation('user', 'type', 'admin');
                            })->where('type', 'new-vendor')->count() }}
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.admin_notifications', ['type' => 'new-order']) }}">
                    <div>
                        <i class="fa-solid fa-bell"></i>
                        طلب جديد
                        <div class="main-badge">
                            {{ App\Models\Notification::where(function ($q) {
                            $q->whereRelation('user', 'type', 'admin');
                            })->where('type', 'new-order')->count() }}
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.admin_notifications', ['type' => 'new-ticket']) }}">
                    <div>
                        <i class="fa-solid fa-bell"></i>
                        تذكرة دعم فني
                        <div class="main-badge">
                            {{ App\Models\Notification::where(function ($q) {
                            $q->whereRelation('user', 'type', 'admin');
                            })->where('type', 'new-ticket')->count() }}
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.admin_notifications', ['type' => 'new-objection']) }}">
                    <div>
                        <i class="fa-solid fa-bell"></i>
                        اعتراض جديد
                        <div class="main-badge">
                            {{ App\Models\Notification::where(function ($q) {
                            $q->whereRelation('user', 'type', 'admin');
                            })->where('type', 'new-objection')->count() }}
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.admin_notifications', ['type' => 'new-delivery']) }}">
                    <div>
                        <i class="fa-solid fa-bell"></i>
                        طلب تسليم
                        <div class="main-badge">
                            {{ App\Models\Notification::where(function ($q) {
                            $q->whereRelation('user', 'type', 'admin');
                            })->where('type', 'new-delivery')->count() }}
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.admin_notifications', ['type' => 'new-withdrawal']) }}">
                    <div>
                        <i class="fa-solid fa-bell"></i>
                        طلب سحب رصيد
                        <div class="main-badge">
                            {{ App\Models\Notification::where(function ($q) {
                            $q->whereRelation('user', 'type', 'admin');
                            })->where('type', 'new-withdrawal')->count() }}
                        </div>
                    </div>
                </a>
            </li>
        </div>
        @endcan
        @can('read_notifications')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#user-notices" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-bell"></i>
                    إشعارات الاعضاء
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="user-notices">
            <li class="list-item">
                <a href="{{ route('admin.notifications.index') }}">
                    <div>
                        <i class="fa-solid fa-bell"></i>
                        الكل
                    </div>
                </a>
            </li>
        </div>
        @endcan
        @can('read_settings')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#settings" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-gear"></i>
                    الاعدادات
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>

        <div class="collapse item-collapse" id="settings">
            @can('general_settings')
            <li class="list-item">
                <a href="{{ route('admin.settings.general') }}">
                    <div>
                        <i class="fa-solid fa-gears"></i>
                        الاعدادات العامة
                    </div>
                </a>
            </li>
            @endcan
            @can('politics_settings')
            <li class="list-item">
                <a href="{{ route('admin.settings.politics') }}">
                    <div>
                        <i class="fa-solid fa-gears "></i>
                        السياسات
                    </div>
                </a>
            </li>
            @endcan
            @can('politics_settings')
            <li class="list-item">
                <a href="{{ route('admin.settings.gold') }}">
                    <div>
                        <i class="fa-solid fa-gears "></i>
                        الضمان الذهبي
                    </div>
                </a>
            </li>
            @endcan
            @can('arbitrationRegulations_settings')
            <li class="list-item">
                <a href="{{ route('admin.settings.arbitrationRegulations') }}">
                    <div>
                        <i class="fa-solid fa-gears "></i>
                        اللائحة التحكيمية
                    </div>
                </a>
            </li>
            @endcan
            @can('invoices_settings')
            <li class="list-item">
                <a href="{{ route('admin.settings.invoices') }}">
                    <div>
                        <i class="fa-brands fa-magento "></i>
                        اعدادات الفواتير
                    </div>
                </a>
            </li>
            @endcan
            @can('orders_settings')
            <li class="list-item">
                <a href="{{ route('admin.settings.orders') }}">
                    <div>
                        <i class="fa-solid fa-box "></i>
                        الطلبات
                    </div>
                </a>
            </li>
            @endcan
            @can('consulting_settings')
            <li class="list-item">
                <a href="{{ route('admin.settings.consulting') }}">
                    <div>
                        <i class="fa-solid fa-box "></i>
                        الاستشارات
                    </div>
                </a>
            </li>
            @endcan
            <li class="list-item">
                <a href="{{ route('admin.settings.specialServices') }}">
                    <div>
                        <i class="fa-solid fa-gears "></i>
                        الطلبات الخاصة
                    </div>
                </a>
            </li>
            @can('memberships_settings')
            <li class="list-item">
                <a href="{{ route('admin.settings.memberships') }}">
                    <div>
                        <i class="fa-solid fa-sliders "></i>
                        اعدادت العضويات
                    </div>
                </a>
            </li>
            @endcan
            @can('sms_settings')
            <li class="list-item">
                <a href="{{ route('admin.settings.sms') }}">
                    <div>
                        <i class="fa-solid fa-comment-sms "></i>
                        اعدادت الرسائل sms
                    </div>
                </a>
            </li>
            @endcan
            @can('read_alerts')
            <li class="list-item">
                <a href="{{ route('admin.alerts.index') }}">
                    <div>
                        <i class="fa-solid fa-bell "></i>
                        مكتبة التنبيهات
                    </div>
                </a>
            </li>
            @endcan
            {{-- @can('sms_settings')
            <li class="list-item">
                <a href="">
                    <div>
                        <i class="fa-solid fa-money-check-dollar "></i>
                        اعدادت بوابة الدفع
                    </div>
                </a>
            </li>
            @endcan --}}
            @can('socialMedia_settings')
            <li class="list-item">
                <a href="{{ route('admin.settings.socialMedia') }}">
                    <div>
                        <i class="fa-regular fa-comment-dots "></i>
                        حسابات التواصل
                    </div>
                </a>
            </li>
            @endcan
        </div>
        @endcan
        @can('read_supervisors')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#admins" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-users-gear "></i>
                    المشرفين
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="admins">
            <li class="list-item">
                <a href="{{ route('admin.admins.index') }}">
                    <div>
                        <i class="fa-solid fa-users-gear "></i>
                        كل المشرفين
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.roles.index') }}">
                    <div>
                        <i class="fa-solid fa-user-pen "></i>
                        صلاحيات المشرفين
                    </div>
                </a>
            </li>
        </div>
        @endcan
        @can('read_users')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#users" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-users "></i>
                    المستخدمين
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="users">
            <li class="list-item">
                <a href="{{ route('admin.clients.index') }}">
                    <div>
                        <i class="fa-solid fa-user "></i>
                        العملاء
                        <div class="main-badge">{{ App\Models\User::clients()->count() }}</div>
                    </div>
                </a>
            </li>

            <li class="list-item">
                <a data-bs-toggle="collapse" href="#lawyer" aria-expanded="false">
                    <div>
                        <i class="fa-solid fa-user-tie "></i>
                        المحامي
                    </div>
                    <i class="fa-solid fa-angle-right arrow"></i>
                </a>
            </li>
            <div class="collapse item-collapse" id="lawyer">
                <li class="list-item">
                    <a href="{{ route('admin.vendors.index') }}">
                        <div>
                            <i class="fa-solid fa-user-tie "></i>
                            الكل
                            <div class="main-badge">{{ App\Models\User::vendors()->count() }}</div>
                        </div>
                    </a>
                </li>
                <li class="list-item">
                    <a href="{{ route('admin.vendors.index', ['membership' => 'individual']) }}">
                        <div>
                            <i class="fa-solid fa-user-tie "></i>
                            المحامي
                            <div class="main-badge">{{ App\Models\User::vendorsindividual()->count() }}</div>
                        </div>
                    </a>
                </li>
                <li class="list-item">
                    <a href="{{ route('admin.vendors.index', ['membership' => 'company']) }}">
                        <div>
                            <i class="fa-solid fa-landmark "></i>
                            محامي الشركات
                            <div class="main-badge">{{ App\Models\User::vendorscompany()->count() }}</div>
                        </div>
                    </a>
                </li>
                <li class="list-item">
                    <a href="{{ route('admin.vendors.qualifications.specialties.statistics') }}">
                        <div>
                            <i class="fa-solid fa-landmark "></i>
                            احصائية التخصص والمؤهل
                        </div>
                    </a>
                </li>
                <li class="list-item">
                    <a href="{{ route('admin.vendors.cities.statistics') }}">
                        <div>
                            <i class="fa-solid fa-landmark "></i>
                            احصائية المدن
                        </div>
                    </a>
                </li>
                <li class="list-item">
                    <a href="{{ route('admin.vendors.notConsultationPrice') }}">
                        <div>
                            <i class="fa-solid fa-landmark "></i>
                            غير مسجلين لسعر الاستشارة
                        </div>
                    </a>
                </li>
            </div>
            <li class="list-item">
                <a data-bs-toggle="collapse" href="#advisors" aria-expanded="false">
                    <div>
                        <i class="fa-solid fa-user-tie "></i>
                        المستشار
                    </div>
                    <i class="fa-solid fa-angle-right arrow"></i>
                </a>
            </li>
            <div class="collapse item-collapse" id="advisors">
                <li class="list-item">
                    <a href="{{ route('admin.advisors.index') }}">
                        <div>
                            <i class="fa-solid fa-user-tie "></i>
                            الكل
                            <div class="main-badge">{{ App\Models\User::advisors()->count() }}</div>
                        </div>
                    </a>
                </li>
                <li class="list-item">
                    <a href="{{ route('admin.advisors.notConsultationPrice') }}">
                        <div>
                            <i class="fa-solid fa-landmark "></i>
                            غير مسجلين لسعر الاستشارة
                        </div>
                    </a>
                </li>
            </div>
            {{-- <li class="list-item">
                <a href="{{ route('admin.judgers.index') }}">
                    <div>
                        <i class="fa-solid fa-user-shield "></i>
                        المحكم
                        <div class="main-badge">{{ App\Models\User::judgers()->count() }}</div>
                    </div>
                </a>
            </li> --}}
            <li class="list-item">
                <a href="{{ route('admin.user.active_requests') }}">
                    <div>
                        <i class="fa-solid fa-user-shield "></i>
                        طلبات التفيعل
                        <div class="main-badge">
                            {{ App\Models\User::whereHas('license', function ($q) {
                            $q->where('status', 'pending');
                            })->orWhereHas('commercial', function ($q) {
                            $q->where('status', 'pending');
                            })->count() }}
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.deletedUsers') }}">
                    <div>
                        <i class="fa-solid fa-user "></i>
                        المستخدمين المحذوفين
                    </div>
                </a>
            </li>
        </div>
        @endcan
        @can('read_departments')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#departments" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-users "></i>
                    الأقسام
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="departments">
            <li class="list-item">
                <a href="{{ route('admin.departments.index') }}">
                    <div>
                        <i class="fa-solid fa-circle "></i>
                        الأقسام الرئيسية
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.departments.sub_departments') }}">
                    <div>
                        <i class="fa-solid fa-circle "></i>
                        الأقسام الفرعية
                    </div>
                </a>
            </li>

        </div>
        @endcan
        @can('read_banks')
        <li class="list-item">
            <a href="{{ route('admin.banks.index') }}" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-users "></i>
                    البنوك
                </div>
            </a>
        </li>
        @endcan
        @can('read_orders')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#orders" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-cart-flatbed-suitcase "></i>
                    الطلبات
                    <div class="main-badge">{{ App\Models\Order::count() }}</div>
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="orders">
            <li class="list-item">
                <a href="{{ route('admin.orders.index') }}">
                    <div>
                        <i class="fa-solid fa-cart-flatbed-suitcase "></i>
                        كل الطلبات
                    </div>
                </a>
            </li>
        </div>
        @endcan
        @can('read_consulting')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#consulting" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-cart-flatbed-suitcase "></i>
                    الاستشارات
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="consulting">

            <li class="list-item">
                <a href="{{ route('admin.consulting.index') }}">
                    <div>
                        <i class="fa-solid fa-cart-flatbed-suitcase "></i>
                        الاستشارات
                        <div class="main-badge">{{ App\Models\Consulting::count() }}</div>
                    </div>
                </a>
            </li>
            @can('clients statistics_consulting')
            <li class="list-item">
                <a href="{{ route('admin.consulting.clients') }}">
                    <div>
                        <i class="fa-solid fa-cart-flatbed-suitcase "></i>
                        احصائية العملاء
                    </div>
                </a>
            </li>
            @endcan
        </div>
        @endcan
        @can('read_specialServices')
        <li class="list-item">
            <a href="{{ route('admin.specialServices.index') }}">
                <div>
                    <i class="fa-solid fa-cart-flatbed-suitcase "></i>
                    الطلبات الخاصة
                    <div class="main-badge">{{ App\Models\SpecialService::count() }}</div>
                </div>
            </a>
        </li>
        @endcan
        {{-- <li class="list-item">
            <a href="{{ route('admin.attorneysContract') }}">
                <div>
                    <i class="fas fa-file-signature"></i>
                    عقد المحاماة
                </div>
            </a>
        </li> --}}
        @can('read_documentation_contracts')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#contracts" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-file-contract "></i>
                    عقود التوثيق
                    <div class="main-badge">0</div>
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="contracts">
            <li class="list-item">
                <a href="">
                    <div>
                        <i class="fa-solid fa-file-contract "></i>
                        عقود التوثيق
                    </div>
                </a>
            </li>
        </div>
        @endcan
        @can('read_financial')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#financial_accounts" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-file-contract "></i>
                    الحسابات المالية
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="financial_accounts">
            <li class="list-item">
                <a href="{{ route('admin.suspended-balances.index') }}">
                    <div>
                        <i class="fa-solid fa-file-contract "></i>
                        المبالغ المعلقة
                        <div class="main-badge">
                            {{ App\Models\SuspendedBalance::count() }}
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.withdrawals.index') }}">
                    <div>
                        <i class="fa-solid fa-file-contract "></i>
                        طلبات السحب
                        <div class="main-badge">
                            {{ App\Models\Withdrawal::count() }}
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.bankTransfers.index') }}">
                    <div>
                        <i class="fa-solid fa-file-contract "></i>
                        التحويلات البنكية
                        <div class="main-badge">
                            {{ App\Models\BankTransfer::count() }}
                        </div>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.refunds.index') }}">
                    <div>
                        <i class="fa-solid fa-file-contract "></i>
                        طلبات الاسترجاع
                        <div class="main-badge">
                            {{ App\Models\Refund::count() }}
                        </div>
                    </div>
                </a>
            </li>
            @can('read_invoices')
            <li class="list-item">
                <a href="{{ route('admin.invoices.index') }}">
                    <div>
                        <i class="fa-solid fa-file-contract "></i>
                        الفواتير
                    </div>
                </a>
            </li>
            @endcan
            @can('read_consulting')
            <li class="list-item">
                <a href="{{ route('admin.consulting.index') }}">
                    <div>
                        <i class="fa-solid fa-cart-flatbed-suitcase "></i>
                        الاستشارات
                        <div class="main-badge">{{ App\Models\Consulting::count() }}</div>
                    </div>
                </a>
            </li>
            @endcan
        </div>
        @endcan
        @can('read_platforms')
        <li class="list-item">
            <a href="{{ route('admin.platforms.index') }}" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-users "></i>
                    من أين تعرفت علينا؟
                </div>
            </a>
        </li>
        @endcan
        @if (
        Gate::allows('read_sliders') ||
        Gate::allows('read_countries') ||
        Gate::allows('read_cities') ||
        Gate::allows('read_occupations') ||
        Gate::allows('read_specialties') ||
        Gate::allows('read_qualifications') ||
        Gate::allows('read_questions') ||
        Gate::allows('read_pages')
        )
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#services" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-network-wired "></i>
                    خدمات الموقع
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="services">
            @can('read_sliders')
            <li class="list-item">
                <a href="{{ route('admin.sliders.index') }}">
                    <div>
                        <i class="fa-solid fa-window-maximize "></i>
                        السلايدر
                    </div>
                </a>
            </li>
            @endcan
            @can('read_countries')
            <li class="list-item">
                <a href="{{ route('admin.countries.index') }}">
                    <div>
                        <i class="fa-solid fa-window-maximize "></i>
                        الدول
                    </div>
                </a>
            </li>
            @endcan
            @can('read_cities')
            <li class="list-item">
                <a href="{{ route('admin.cities.index') }}">
                    <div>
                        <i class="fa-solid fa-window-maximize "></i>
                        المدن
                    </div>
                </a>
            </li>
            @endcan
            @can('read_occupations')
            <li class="list-item">
                <a href="{{ route('admin.occupations.index') }}">
                    <div>
                        <i class="fa-solid fa-window-maximize "></i>
                        الوظائف
                    </div>
                </a>
            </li>
            @endcan
            @can('read_specialties')
            <li class="list-item">
                <a href="{{ route('admin.specialties.index') }}">
                    <div>
                        <i class="fa-solid fa-window-maximize "></i>
                        التخصصات
                    </div>
                </a>
            </li>
            @endcan
            @can('read_qualifications')
            <li class="list-item">
                <a href="{{ route('admin.qualifications.index') }}">
                    <div>
                        <i class="fa-solid fa-window-maximize "></i>
                        المؤهلات
                    </div>
                </a>
            </li>
            @endcan
            @can('read_questions')
            <li class="list-item">
                <a href="{{ route('admin.questions.index') }}">
                    <div>
                        <i class="fa-solid fa-file-contract "></i>
                        الاسئله الشائعة
                    </div>
                </a>
            </li>
            @endcan
            @can('read_pages')
            <li class="list-item">
                <a href="{{ route('admin.website-pages.index') }}">
                    <div>
                        <i class="fa-solid fa-window-maximize "></i>
                        صفحات الموقع
                    </div>
                </a>
            </li>
            @endcan
        </div>
        @endif
        @can('read_tickets')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#support" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-headset "></i>
                    الدعم الفني
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="support">
            <li class="list-item">
                <a href="{{ route('admin.tickets.index') }}">
                    <div>
                        <i class="fa-solid fa-ticket "></i>
                        التذاكر
                        <div class="main-badge">{{ App\Models\Ticket::count() }}</div>
                    </div>
                </a>
            </li>
        </div>
        @endcan

        @can('read_ips')
        <li class="list-item">
            <a data-bs-toggle="collapse" href="#IP" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-headset "></i>
                    IP's
                </div>
                <i class="fa-solid fa-angle-right arrow"></i>
            </a>
        </li>
        <div class="collapse item-collapse" id="IP">
            <li class="list-item">
                <a href="{{ route('admin.ips.index', ['type' => 'visitor']) }}">
                    <div>
                        <i class="fa-solid fa-ticket "></i>
                        الزوار
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="{{ route('admin.ips.index', ['type' => 'nafath']) }}">
                    <div>
                        <i class="fa-solid fa-message "></i>
                        نفاذ
                    </div>
                </a>
            </li>
        </div>
        @endcan
        @can('read_SMS')
        <li class="list-item">
            <a href="{{ route('admin.sms.index') }}" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-envelope"></i>
                    رسائل SMS
                </div>
            </a>
        </li>
        @endcan
        @can('read_email_templates')
        <li class="list-item">
            <a href="{{ route('admin.email_templates.index') }}" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-envelope"></i>
                    قوالب الايميلات
                </div>
            </a>
        </li>
        @endcan
        @can('read_contact')
        <li class="list-item">
            <a href="{{ route('admin.contact-us.index') }}" aria-expanded="false">
                <div>
                    <i class="fa-solid fa-phone-flip "></i>
                    اتصل بنا
                    <div class="main-badge">{{ App\Models\ContactUs::count() }}</div>
                </div>
            </a>
        </li>
        @endcan
    </ul>
</div>
