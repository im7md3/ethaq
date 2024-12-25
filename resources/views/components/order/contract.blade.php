<style>
    #printContract * {
        text-align: right;
        direction: rtl;
    }

    #printContract .form-control {
        margin: 7px 0;
        padding: 5px !important;
        font-size: 12px !important;
        width: 200px !important;
        max-width: 100% !important;
    }

    #printContract label {
        font-size: 12px !important;
    }

    #printContract ul {
        display: inline-block !important;
    }

    #printContract li {
        list-style: none;
        position: relative;
    }

    #printContract li::before {
        position: absolute;
        content: "";
        width: 6px;
        height: 6px;
        background-color: #333333;
        right: 35px;
        top: 7px;
        border-radius: 50%;
    }
    ol {
        padding-right: 3.2rem !important;
    }
    ol li{
        list-style: auto !important;
    }
    ol li::before{
        content:none !important;
    }
</style>
<section class="py-3 height-section contract" id="printContract">
    <div class="container ">
        <h5 class="text-center mb-2 fw-bold">عقد المحاماة</h5>
        <p class="text-center text-fs-17 fw-600">رقم<span>:</span> <span>{{ $order->id }}</span></p>
        <div class="mb-2 header-pin d-flex align-items-center justify-content-between">
            <div>
                <p>الحمدلله وحده والصلاة والسلام على من لا نبي بعده, وبعد<span>:</span></p>
                <p>
                    ففي يوم <span id="">{{ Carbon::now()->translatedFormat('D') }}</span> تاريخ <span class="">{{
                        today()->format('Y-m-d') }}</span> وفي
                    مدينة
                    الرياض
                    أبرم هذا العقد بين كلاً من<span>:</span>
                </p>
            </div>
            @if(!Request::routeIs('api.front.contracts.webView',$order->hash_code))
            <div class="qr-holder">
                {!! QrCode::size(100)->backgroundColor(255,255,255)->generate(route(auth()->user()->type.'.contracts.show',$order->hash_code)) !!}
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-6">
                <h6 class="mb-2 contr-title">الطرف الاول<span>:</span> المحامي</h6>
                <div class="row row-gap-24 mb-2 ">
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark">الاسم<span>:</span></label>
                        <small class="d-block text-dark"> {{ $order->vendor->name }} </small>

                    </div>

                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> رقم الترخيص<span>:</span></label>
                            <small class="d-block text-dark"> {{ $order->vendor->license->name }} </small>
                    </div>

                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> رقم الهوية الوطنية<span>:</span></label>
                            <small class="d-block text-dark"> {{ $order->vendor->id_number }} </small>
                    </div>

                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> العنوان الوطني<span>:</span></label>
                            <small class="d-block text-dark"> {{ $order->vendor->address }} </small>
                        </div>
                        <div class="col-sm-6  col-md-4">
                            <label for="" class="grey-color-dark"> الهاتف<span>:</span></label>
                            <small class="d-block text-dark"> {{ $order->vendor->phone }} </small>
                        </div>
                        <div class="col-sm-6  col-md-4">
                            <label for="" class="grey-color-dark"> البريد الالكتروني<span>:</span></label>
                            <small class="d-block text-dark"> {{ $order->vendor->email }} </small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="mb-2 contr-title">الطرف الثاني<span>:</span> العميل</h6>
                <div class="row row-gap-24 mb-2 ">
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark">الاسم<span>:</span></label>
                        <small class="d-block text-dark"> {{ $order->client->name }} </small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> رقم الهوية الوطنية<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->client->id_number }} </small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> العنوان الوطني<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->client->address }} </small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> الهاتف<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->client->phone }}</small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> البريد الالكتروني<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->client->email }}</small>
                    </div>
                </div>
            </div>
            @if($order->first_judger_id)
            <!-- <div class="col-md-6">
                <h6 class="mb-2 contr-title">الطرف الثالث<span>:</span> محكم الأصيل</h6>
                <div class="row row-gap-24 mb-2 ">
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark">الاسم<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->firstJudger->name }}</small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> رقم الهوية <span>:</span></label>
                        <small class="d-block text-dark">{{ $order->firstJudger->id_number }}</small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> المؤهل <span>:</span></label>
                        <small class="d-block text-dark">{{ $order->firstJudger->qualification?->name }}</small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> العنوان الوطني<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->firstJudger->address }}</small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> الهاتف<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->firstJudger->phone }}</small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> البريد الالكتروني<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->firstJudger->email }}</small>
                    </div>
                </div>
            </div> -->
            @endif
            @if($order->second_judger_id)
            <!-- <div class="col-md-6">
                <h6 class="mb-2 contr-title">الطرف الرابع<span>:</span> محكم الاحتياطي</h6>
                <div class="row row-gap-24 mb-2 ">
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark">الاسم<span>:</span></label>
                            <small class="d-block text-dark">{{ $order->secondJudger->name }}</small>
                        </div>
                        <div class="col-sm-6  col-md-4">
                            <label for="" class="grey-color-dark"> رقم الهوية <span>:</span></label>
                            <small class="d-block text-dark">{{ $order->secondJudger->id_number }}</small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> المؤهل <span>:</span></label>
                            <small class="d-block text-dark">{{ $order->secondJudger->qualification?->name }}</small>
                    </div>
                    <div class="col-sm-6  col-md-4">
                        <label for="" class="grey-color-dark"> العنوان الوطني<span>:</span></label>
                            <small class="d-block text-dark">{{ $order->secondJudger->address }}</small>
                        </div>
                        <div class="col-sm-6  col-md-4">
                            <label for="" class="grey-color-dark"> الهاتف<span>:</span></label>
                            <small class="d-block text-dark">{{ $order->secondJudger->phone }}</small>
                        </div>
                        <div class="col-sm-6  col-md-4">
                            <label for="" class="grey-color-dark"> البريد الالكتروني<span>:</span></label>
                            <small class="d-block text-dark">{{ $order->secondJudger->email }}</small>
                        </div>
                    </div>
                </div>
                @endif
            </div> -->
            <h6 class="text-center mb-2 mt-4">
                المقدمة
            </h6>
            <p class=" mb-0">
            حيث إنّ أطراف العقد الواردة بياناتهم أعلاه، اتفقوا على تنفيذ الخدمة القانونية من خلال منصة وتطبيق إيثاق التي تعد وسيطاً بينهم لتنفيذ التزاماتهم والمملوكة لصالح شركة إيثاق لخدمات الأعمال السجل التجاري رقم (1010744867)، وقد أقرَّ الأطراف على الالتزام بما تضمنته شروط الاستخدام وسياسة الخصوصية من أحكام وشروط وغيرها الواردة في منصة إيثاق (https://ethaq.com.sa)، وبذلك يبطل ما يتعارض معها في هذا العقد، وعليه فقد اتفق أطراف العقد بالإيجاب والقبول وهما بكامل الأهلية المعتبرة شرعاً ونظاماً، ووفقاً لما يلي<span>:</span>
            <br>
            المادة الأولى<span>:</span> المقدمة
            <br>
            تعد المقدمة أعلاه جزءاً لا يتجزأ ومكملاً يقرأ ويفسر مع هذا العقد.
            <br>
            المادة الثانية<span>:</span> نطاق الأعمال
        </p>
        <ul class=" fw-bold p-0 ">

            <li class="pe-5 mb-1 line-text">
                الفقرة الأولى<span>:</span> حصر الأعمال المطلوب تنفيذها تفصيلاً<span>:</span>
                <div class="line-text mb-2">
                    {{$order->activeOffer->works }}
                </div>
            </li>
            <li class="pe-5 mb-1 ">
                الفقرة الثانية<span>:</span> حصر المتطلبات والمستندات الأساسية للأعمال المطلوب تنفيذها يجب إرفاقها بصيغة
                <span>pdf</span><span>/</span><span>jpg</span> <span>:</span>
                <div class="line-text mb-2">
                    {{ $order->activeOffer->documents }}
                </div>
            </li>
            <li class="pe-5 mb-1">
                الفقرة الثالثة<span>:</span> طريقة ووسائل تنفيذها <span>:</span> {{
                $order->activeOffer->ExecutionMethodEncoded }}
            </li>

        </ul>

        <h6>المادة الثالثة<span>:</span> مدة التنفيذ
        </h6>
        @if($order->activeOffer->duration=='specified')
        <p class="">
            1. يلتزم المحامي من تاريخ سداد العميل لكامل مبلغ الأتعاب من خلال المنصة بالبدء بتنفيذ الأعمال المتفق عليها
            في
            العقد خلال مدة
                <span class="text-dark">{{ $order->activeOffer->period }}</span>
            وتنقضي بانتهائها حسب المعمول به نظاماً، ما لم يتم طلب التمديد والموافقة عليه من الطرف الآخر.
        </p>
        @else
        <p class="">
            2. يلتزم المحامي من تاريخ سداد العميل لكامل مبلغ الأتعاب من خلال المنصة بالبدء بتنفيذ الأعمال المتفق عليها
            في
            العقد حتى انتهائها بــــ
                 وتنقضي مدة العقد به ما لم يتفق الطرفان على تعديل نطاق
                <span class="text-dark">{{ $order->activeOffer->period }}</span>
            العقد بشرط عدم اختلاف أساسه، ويعتبر أي اتفاق
            بالمخالفة لذلك باطلاً ولا يعتد به.
        </p>
        @endif
        <h6>المادة الرابعة<span>:</span> الالتزامات والأحكام العامة لأطراف العقد<span>:</span>
        </h6>
        <ul class=" p-0">

            <li class="pe-5 mb-1">
            التزام جميع أطراف العقد مراعاة جميع الأحكام الشرعية والأنظمة المرعية في المملكة العربية السعودية وحقوق الملكية الفكرية المرعية في المملكة العربية السعودية.
            </li>
            <li class="pe-5 mb-1">
            الالتزام بالآداب العامة في جميع التصرفات بين أطراف العقد وعبر إيثاق.
            </li>
            <li class="pe-5 mb-1">
            الالتزام بما تضمنته سياسة الخصوصية وشروط الاستخدام لإيثاق.
            </li>
            <li class="pe-5 mb-1">
            الالتزام ببذل العناية اللازمة لتنفيذ الخدمات المكلف بها في هذا العقد
            </li>
            <li class="pe-5 mb-1">
            الالتزام بصحة وسلامة المعلومات التي يمكن أن تؤثر على الخدمات المقدمة المتفق عليها.
            </li>
            <li class="pe-5 mb-1">
            الالتزام بتقديم ما يثبت الصفة القانونية لأطراف العقد في حال ما إذا كان أحد الأطراف ينوب عن الغير.
            </li>
            <li class="pe-5 mb-1">
            يعتبر التقويم الميلادي هو التقويم المعتبر في هذا العقد.
            </li>
            <li class="pe-5 mb-1">
            اعتبار أيام العمل بدايةً من يوم الأحد إلى يوم الخميس.
            </li>
            <li class="pe-5 mb-1">
                اعتبار اللغة العربية هي اللغة الأساسية للعقد وتنفيذ التزاماته.
            </li>

        </ul>
        <h6>
            المادة الخامسة<span>:</span> التزامات أطراف العقد الخاصة<span>:</span>
        </h6>
        <p class=" mb-0">أ -التزامات العميل<span>:</span> </p>
        <ul class=" p-0">

            <li class="pe-5 mb-1">
            يلتزم بتقديم المتطلبات التي يحتاجها ويطلبها الأطراف المتعاقدين لتنفيذ هذا العقد.
            </li>
            <li class="pe-5 mb-1">
                يلتزم بالرد والإجابة على استفسارات وأسئلة المحامي .
            </li>

            <li class="pe-5 mb-1">
            يلتزم بتزويد المحامي أو من ينيبه بوكالة شرعية تخوله حق السير في موضوع هذا العقد.
            </li>
            <li class="pe-5 mb-1">
            يلتزم العميل بالتعامل مع المحامي في تبادل البيانات والمعلومات عبر المنصة والتطبيق لإيثاق فقط، وفي حال التعامل خارج المنصة والتطبيق فإن ذلك الإجراء لا يعتد به ولا يعتبر في تنفيذ هذا العقد.
            </li>
            <li class="pe-5 mb-1">
            بالإضافة إلى أتعاب المحاماة يلتزم العميل بدفع جميع ما يتطلبه عمل المحامي من رسوم تتعلق بتنفيذ أعمال العقد كالتكاليف القضائية في حال أنها فرضت وكذلك تكاليف الخبراء والمترجمين والمحاسبين وغيرهم.
            </li>
            <li class="pe-5 mb-1">
            يلتزم العميل في حال الاعتراض على الخدمات المقدمة من قبل المحامي أن يقوم بإشعار المنصة عن محل الإشكال أو النزاع في تنفيذ العقد خلال يومي عمل من نشوئه عبر البريد الإلكتروني info@ethaq.com.sa وإلا فإنه يعد مقراً وراضياً على الإجراء المنفذ.
            </li>
        </ul>

        <p class=" mb-0">ب-التزامات المحامي<span>:</span></p>
        <ul class=" p-0">
            <li class="pe-5 mb-1">
            يلتزم المحامي بتنفيذ جميع الأعمال المتفق عليها من خلال المنصة والتطبيق لإيثاق وخلال المدة المحددة في العقد، وكل ما يستلزم لإتمام تلك الأعمال، وفي حال التعامل خارج المنصة والتطبيق فإن ذلك الإجراء لا يعتد به ولا يعتبر في تنفيذ هذا العقد.

            </li>
            <li class="pe-5 mb-1">
                يلتزم بالرد والإجابة على الاستفسارات والأسئلة من الأطراف المتعاقدين معه خلال مدة {{ $order->activeOffer->response_speed }}.
            </li>

            <li class="pe-5 mb-1">
            يلتزم المحامي بإشعار المنصة عن محل الإشكال أو النزاع في تنفيذ العقد خلال يومي عمل من نشوئه عبر البريد الإلكتروني info@ethaq.com.sa، وبعد مضي يومي العمل دون أي إشعار عبر البريد يكون مقراً وراضياً على الإجراء المنفذ.
            </li>
            <li class="pe-5 mb-1">
            يستحق المحامي المقابل المالي حال تنفيذه جميع الأعمال والخدمات المتفق عليها كاملةً، ويكون الاستحقاق بعد الضغط على خانة تسليم الأعمال للعميل ولا يكتفى بتنفيذها فقط دون الضغط على ايقونة تسليم الأعمال، ويكون المقابل المالي نظير الالتزام بكامل الأعمال ووفق المدة الزمنية المتفق عليها، وفي حال عدم تسليم الأعمال أو تقديمها جزئياً بخلاف ما تم الاتفاق عليه، فإنه يحق للعميل استرداد جميع ما دفعه من أتعاب كاملةً، ولا يكون المحامي مستحقاً لأي جزء منها ويعد ذلك تنازلاً منه عن الأتعاب لعدم التزامه بتقديمها كاملةً دون أي نقص.
            </li>
            <li class="pe-5 mb-1">
            يلتزم المحامي بجميع الأنظمة المرعية في المملكة العربية السعودية وجميع اللوائح والقرارات وغيرها.
            </li>
        </ul>
        <!-- @if ($order->first_judger_id)
        <h6>إفصاح المحكم<span>:</span></h6>

        <p class=" contr-title fit-content">المحكم الأصيل<span>:</span></p>
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">أقر أنا<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->firstJudger->name }}</small>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">رقم الهوية<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->firstJudger->id_number }}</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">رقم العقد<span>:</span></label>
                    <small class="d-block text-dark">{{ $order->id }}</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">اسم الطرف الاول<span>:</span></label>
                    <small class="d-block text-dark">{{ $order->client->name }}</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">اسم الطرف الثاني<span>:</span></label>
                    <small class="d-block text-dark">{{ $order->vendor->name }}</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">التاريخ<span>:</span></label>
                    <small class="d-block text-dark">{{ today()->format('Y-m-d') }}</small>
                </div>
            </div>
            <div class="col-md-5">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">موضوع العقد<span>:</span></label>
                    <small class="d-block text-dark">{{ $order->title }}</small>
                </div>
            </div> --}}
            {{-- @if($order->selectedJudgers()->latest('id')->take(2)->where('client_decision','accepted')->where('judger_decision','accepted')->wherePivot('type','main')->first()->pivot->rejected)
            <div class="col-md-6">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">موانع التحكيم<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->selectedJudgers()->latest('id')->take(2)->where('client_decision','accepted')->where('judger_decision','accepted')->wherePivot('type','main')->first()->pivot->rejected }}</small>
                </div>
            </div>
            @endif --}}
            @if($order->selectedJudgers()->latest('id')->take(2)->where('client_decision','accepted')->where('judger_decision','accepted')->wherePivot('type','main')->first()->pivot->rejected)
            <div class="col-12">
                بأني قبلت تعيني محكماً في هذا العقد، وأفيد بأن لدي أحد الموانع للتحكيم يتمثل في {{
                $order->selectedJudgers()->latest('id')->take(2)->where('client_decision','accepted')->where('judger_decision','accepted')->wherePivot('type','main')->first()->pivot->rejected
                }}
                ،
                وباطلاع الأطراف عليه والبدء في تنفيذ العقد يقرون بالموافقة وعدم الممانعة في ممارستي للتحكيم.
            </div>
            @else
            <div class="col-12">
                بأني قبلت تعيني محكماً في هذا العقد،
                وأني أتعهد بعدم وجود أي مانع شرعي أو نظامي يحول بيني وبين ممارستي
                للتحكيم فيه، كما أتعهد بإشعار جميع الأطراف في حال وجوده مستقبلاً.
            </div>
        </div>
        @endif



        <p class="  contr-title mt-4 fit-content">المحكم الاحتياطي<span>:</span></p>
        <div class="row mb-4 ">
            <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">الاسم<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->secondJudger->name }}</small>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">رقم الهوية<span>:</span></label>
                        <small class="d-block text-dark">{{ $order->secondJudger->id_number }}</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">رقم العقد<span>:</span></label>
                    <small class="d-block text-dark"></small>
            </div>
            <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">اسم الطرف الاول<span>:</span></label>
                    <small class="d-block text-dark"></small>
            </div>
            <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">اسم الطرف الثاني<span>:</span></label>
                    <small class="d-block text-dark"></small>
            </div>
            <div class="col-md-3">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">التاريخ<span>:</span></label>
                    <small class="d-block text-dark"></small>
            </div>
            <div class="col-md-5">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">موضوع العقد<span>:</span></label>
                    <small class="d-block text-dark"></small>
            </div> --}}
            {{-- @if($order->selectedJudgers()->latest('id')->take(2)->where('client_decision','accepted')->where('judger_decision','accepted')->wherePivot('type','sub')->first()->pivot->rejected)
            <div class="col-md-6">
                <div class="inp-holder">
                    <label for="" class="grey-color-dark">موانع التحكيم<span>:</span></label>
                </div>
            </div>
            @endif --}}
            @if($order->selectedJudgers()->latest('id')->take(2)->where('client_decision','accepted')->where('judger_decision','accepted')->wherePivot('type','sub')->first()->pivot->rejected)
            <div class="col-12">
                بأني قبلت تعيني محكماً في هذا العقد، وأفيد بأن لدي أحد الموانع للتحكيم يتمثل في {{
                $order->selectedJudgers()->latest('id')->take(2)->where('client_decision','accepted')->where('judger_decision','accepted')->wherePivot('type','sub')->first()->pivot->rejected
                }}
                ،
                وباطلاع الأطراف عليه والبدء في تنفيذ العقد يقرون بالموافقة وعدم الممانعة في ممارستي للتحكيم.
            </div>
            @else
            <div class="col-12">
                بأني قبلت تعيني محكماً في هذا العقد،
                وأني أتعهد بعدم وجود أي مانع شرعي أو نظامي يحول بيني وبين ممارستي
                للتحكيم فيه، كما أتعهد بإشعار جميع الأطراف في حال وجوده مستقبلاً.
            </div>
            @endif
        </div>
        @endif -->

        <ul class=" p-0">
            <span class="mb-2">المادة السادسة<span>:</span> المدفوعات/ المقابل المالي</span>
            <li class="fw-bold pe-5">يلتزم العميل والمحامي بآلية دفع المقابل المالي للعقد وفقاً لما يلي<span>:</span>
            </li>
            <li class="pe-5 mb-1">
            من المتفق عليه بين طرفي العقد أن القيمة الإجمالية للتعاقد بمبلغ وقدره  {{
                $order->activeOffer->amount
                }} ريال سعودي بالإضافة إلى ضريبة القيمة المضافة وقدرها
                 {{ $order->activeOffer->amount * (setting('contract_tax')/100) }}
                 ريال، والتي يلتزم العميل بسدادها خلال 120 ساعة من تاريخ صدور الفاتورة. وفي حال عدم التزام العميل بسداد قيمة العقد خلال المدة المتفق عليها فيعتبر ذلك إلغاءً منه للعقد.
            </li>
            <li class="pe-5 mb-1">
            من المتفق عليه بين الأطراف أنه في حال استرجاع أي مبالغ لأي من الطرفين فإن استحقاق المنصة منها لما نسبته 2% من إجمالي المبلغ مقابل رسوم إدارية لاستخدام المنصة ولرسوم الاسترجاع المفروضة من وسيط الدفع الإلكتروني.
            </li>
            <li class="pe-5 mb-1">
                سداد التكاليف عن طريق وسائل الدفع والسداد والحسابات الموضحة في المنصة – على سبيل
                المثال لا الحصر –
                التحويل
                البنكي عبر الآيبان التالي
                    <span class="text-dark">{{ setting('iban') }}</span>  أو عبر أنظمة السداد
                الإلكتروني، كالبطاقات الائتمانية، وخدمة سداد،
                وفي
                حال قرر دفع قيمة تكاليف الخدمة المطلوبة عن طريق بطاقة ائتمانية، فإنه يوافق دون قيدٍ أو شرط للمنصة أو
                الجهة
                التي قد تتعاقد معها المنصة لهذا الغرض– بحسب الأحوال – بقيد العملية وخصم المبلغ المستحق أو حجزه من
                البطاقة
                الائتمانية التي يقوم بها لتسجيل بياناتها في المنصة، وفي جميع الأحوال فلا يعتد بأي مدفوعات خارج المنصة.
            </li>
            <li class="pe-5 mb-1">جميع عمليات الدفع تتم بالريال السعودي، وفي حال قام بالدفع باستخدام عملة أخرى فإنه
                يتحمل النفقات والأجور
                المترتبة على تحويل العملة أو أي رسوم بنكية أخرى.</li>
            <li class="fw-bold pe-5">يلتزم العميل والمحامي بآلية استرداد واسترجاع المقابل المالي<span>:</span></li>
            <li class="pe-5 mb-1">
                يتم الاسترجاع للعميل ما تم دفعه ابتداءً في العقد من أتعاب المحاماة عند عدم تنفيذ المحامي للأعمال المتفق عليها كاملةً، وذلك بعد مضي مدة يومي عمل من انتهاء المدة المحددة في العقد، ما لم يتم الاعتراض على ذلك من قبل المحامي خلال فترة الاعتراض المشار لها في العقد، وفي حال الاعتراض خلال المدة يتم تعليق المبلغ حتى صدور حكم نهائي بذلك يتم إرساله عبر الايميل info@ethaq.com.sa، وفي حال الاعتراض بعد مضي المدة المحددة للاعتراض فإنه لا يحق تعليق المبلغ ويكون مستحق للدفع وإن تم الاعتراض أمام الجهات القضائية بعد ذلك، ويقر الأطراف بإخلاء مسؤولية شركة إيثاق لخدمات الأعمال عن التصرف التي قامت به بموجب ما تضمنته آلية الدفع المنصوص عليها في هذا العقد وشروط الاستخدام وسياسة الخصوصية.
            <li class="mb-3 pe-5">
                آلية الاحتفاظ بالمقابل المالي
                <span>:</span>
            <p class="mb-0">
            من المتفق عليه بين أطراف العقد أن دور إيثاق في احتفاظها للمقابل المالي إنما هو على سبيل الوديعة، وعليه يتم الاحتفاظ بالمقابل المالي إلى حين:
            </p>
            </li>
            <ol>
            <li class="fw-bold">
            مضي يوميّ عمل من تنفيذ العقد دون الاعتراض عليه.
                </li>
                <li class="fw-bold">مضي يوميّ عمل من اختيار المحامي لخانة تسليم الأعمال دون الاعتراض عليه.</li>
                <li class="fw-bold">
                إلى حين صدور حكم على الاعتراض في هذا العقد والمصادقة عليه من الجهات المختصة.
                </li>
            </ol>
        </ul>
        <p class="mb-2">المادة السابعة<span>:</span> طريقة حل النزاع<span>:</span></p>
        <ul class=" p-0">
            <li class="pe-5 mb-1">
            أقرّ أطراف العقد في حال نشوء أي نوع من أنواع النزاع أو الخلاف أو الاعتراض حول تنفيذ أو تفسير هذا العقد يحال ذلك إلى الجهات القضائية المختصة في مدينة الرياض.
            </li>
            <li class="pe-5 mb-1">
            يلتزم الأطراف وخصوصاُ الطرف المعترض أو مقيم الدعوى القضائية الإشعار لــ إيثاق عبر البريد الإلكتروني (info@Ethaq.com.sa) بالاعتراض المقدم خلال مدة لا تتجاوز يومي عمل من تاريخ نشوء النزاع أو الخلاف أو الاعتراض، وبشرط أن يدون في عنوان البريد رقم الطلب واسم المعترض الأصيل في العقد، وفي حال الإخلال بذلك فإن المنصة تخلي مسؤوليتها وفق ما سلف بيانه.
            </li>
        </ul>
        <span class="mb-2 d-block">المادة الثامنة<span>:</span> حالات انتهاء/إنهاء العقد<span>:</span></span>
        <ul class=" p-0">
            <li class="pe-5 mb-1">
                بإرادة طرف في العقد<span>:</span>
                <br>
                عند قيام أحد طرفي العقد بإرادته خلال مدة سريان العقد بأي تصرف يعد إخلالاً بالعقد وفقاً لما تم الاتفاق عليه في هذه العقد وشروط وسياسة استخدام المنصة بطلب إنهاء التعاقد عبر المنصة وإشعار إيثاق عبر البريد الإلكتروني (info@Ethaq.com.sa) بشرط أن يشتمل على رقم العقد واسم صاحب الطلب الأصيل في العقد، ويعتبر مجرد التقدم بطلب إنهاء التعاقد فسخاً للعقد، ويستلزم بعد ذلك في حال عدم موافقة الطرف الآخر على الفسخ، أن يحال إلى الجهات القضائية وفق ما سلف.
            </li>
            <li class="pe-5 mb-1">
                بغير إرادة طرفي العقد<span>:</span>
                <br>
                - في حال أصاب أحدهم أي عارض صحي أو غيره يعيق تنفيذ التزامه في العقد على سبيل المثال وفاة أحد الأطراف أو مرضه أو سجنه خلال مدة سريان العقد.
                <br>
                - في جميع أحوال انتهاء العقد بغير إرادة العميل أو المحامي يشترط صدور حكم قضائي بإثبات الاستحقاق من عدمه للمقابل المالي.
            </li>
        </ul>
        <span>:</span>
        <span class="mb-4 d-block">المادة التاسعة<span>:</span> القوة القاهرة</span>
        <ul class=" p-0">
            <li class="pe-5 mb-1">
            القوة القاهرة هي الحدث العام الذي يخرج عن سيطرة أطراف العقد ولا يمكن توقعه ويستحيل دفعه كما يستحيل تنفيذ التزامات المتعاقد أثناء قيامها، ولا يعزى لتسبب أو خطأ أو إهمال من أحد الأطراف أو أي شخص آخر، ويشمل -على سبيل المثال لا الحصر- الحريق والفيضان والحوادث والحرب والعمليات العسكرية والحظر الاقتصادي، وانقطاع شبكات الاتصال، والاختراقات التقنية للمنصة، ولا يشمل ذلك ما يخضع لسيطرة المتعاقد.
        </li>
            <li class="pe-5 mb-1">
            لا يُعد من القوة القاهرة تأخر التَّنفيذ بسبب تقصير أيٍّ من أطراف العقد أو عدم الكفاءة في العمل ما لم يكن النقص في ذلك من القوة القاهرة.
            </li>
            <li class="pe-5 mb-1">
            في حال حصول قوة قاهرة تتعلق بالمنصة على سبيل المثال لا الحصر انقطاع شبكات الاتصال، أو الاختراقات التقنية للمنصة، أو تعطل استخدامها لأسباب خارجة عن إرادتها، سوف يتم إشعار الأطراف عبر وسائل التواصل للمنصة بالطرق البديلة حال توفرها.

        </li>
            <li class="pe-5 mb-1">
            يقوم المتعاقد بما يلزم من خلال بذل أقصى جهده لتقليل آثار القوة القاهرة على تنفيذ وتقديم الأعمال في الموعد المتفق عليه، ويجب على المتعاقد في حال التأخر عن تنفيذ الأعمال بسبب القوة القاهرة إخطار الطرف الآخر في حينها بحقه في إنهاء العقد أو تأجيل تنفيذه بالاتفاق بينهما إذا أصبح تنفيذ الأعمال مستحيلًا لاستمرار القوة القاهرة لمدة تتجاوز يومي عمل.
        </li>
        </ul>
        <span class="mb-2 d-block">المادة العاشرة<span>:</span> الإشعارات</span>
        <p>
        أقرَّ أطراف العقد على أن البيانات الشخصية المدونة في صدر هذا العقد هي البيانات المعتمدة في الاشعارات، وفي حال تغييرها عليه مسؤولية إشعار المنصة وأطراف العقد خلال مدة لا تتجاوز 24 ساعة، وإلاّ صح التبليغ على البيانات المبينة في صدر هذا العقد.

    </p>
        <span class="mb-2 d-block">المادة الحادي عشر<span>:</span> ملحقات العقد</span>
        <p>
        تتكون ملحقات هذا العقد من شروط الاستخدام وسياسة الخصوصية للمنصة المعتمدة والتي تعد جميعها جزءً لا يتجزأ من هذا العقد تقرأ وتفسر معه، وفي حال تعارضهما فإن ما يكون متعلقاً بحقوق المنصة فإن العبرة ما نصت عليه شروط الاستخدام وسياسة الخصوصية وما كان متعلقاً بحقوق الأطراف التي لا علاقة للمنصة بها فإن الأصل ما تضمنته العقد المبرم بين الأطراف.

        </p>
        <span class="mb-2 d-block">المادة الثاني عشر<span>:</span> التعديل على العقد</span>
        <p>
        يمنع بعد اعتماد العقد التعديل على أي التزام من التزامات العقد أو أي بند آخر.

    </p>
        <span class="mb-2 d-block">المادة الثالث عشر<span>:</span> نسخ العقد</span>
        <p>
        أقرَّ أطراف العقد على أن نسخة العقد الإلكترونية في المنصة هي النسخة المعتمدة، وباللغة العربية مكونة من ثلاثة عشر مادة وخمس صفحات، وتم تزويد هذه النسخة الالكترونية لأطراف العقد، ونسخة للمنصة، ويمكن لأطراف العقد الاطلاع عليها عبر المنصة وحفظها، وأن لها حجية بذاتها مساوية للنسخ الورقية بعد اعتمادها من أطراف العقد.
    </p>

    </div>
    @if($order->accepted_contract_date)
    <div class="">
        تاريخ قبول العقد: {{ $order->accepted_contract_date }}
    </div>
    @endif
</div>
</section>
