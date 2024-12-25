<section class="height-section">
                    <p class="text-center mb-4">بسم الله الرحمن الرحيم</p>
                    <h6 class="text-center fw-bold ">
                        <span class="d-block mb-2">
                            قرار رقم <span>({{ $order->id }})</span>
                        </span>
                        الصادر للفصل في عقد المحاماة رقم <span>({{ $order->id }})</span>
                    </h6>
                    <h6 class=" mb-4 fw-bold">
                        <span class="d-block mb-2">
                            المقامة من {{ $order->client->name }} هوية رقم <span>({{ $order->client->id_number }})</span>العنوان الوطني <span> {{ $order->client->address }}</span>الهاتف <span>{{ $order->client->phone }}</span>البريد الالكتروني <span>{{ $order->client->email }}</span>
                        </span>
                        ضد {{ $order->vendor->name }} رقم الترخيص <spam>{{ $order->vendor->license->name }}</spam><span>/</span>هوية رقم <span>({{ $order->vendor->id_number }})</span>وعنوانه <span>{{ $order->vendor->address }}</span> الهاتف <span>{{ $order->vendor->phone }}</span> البريد الالكتروني <span>{{ $order->vendor->email }}</span>
                    </h6>
                    <p class="lh-lg">
                        الحمد لله والصلاة والسلام على رسول الله وعلى آله وصحبه اجمعين، وبعد:
                        <br>
                        بناءاً على نظام التحكيم الصادر في ٢٤/٠٥/١٤٣٣هـ الموافق ٢٠١٢/٠٤/١٦م مرسوم ملكي رقم م / ٣٤ بتاريخ ٢٤ / ٥/
                        ١٤٣٣هـ
                        قرار مجلس الوزراء رقم ١٥٦ بتاريخ ١٧/ ٥/ ١٤٣٣هـ وبما تضمنه المادة الرابعة والخامسة من النظام بموافقة
                        الطرفين
                        لإخضاع العلاقة والإجراءات للائحة التحكيمية لمنصة الموثوق وجميع ما جاء بها يطابق الأنظمة المرعية في
                        المملكة
                        العربية السعودية.
                        <br>
                        ففي يوم ({{ today()->translatedFormat('D') }}) {{ today()->format('Y-m-d') }} الموافق {{ today()->format('Y-m-d') }}
                        بعد النظر في النزاع رقم ({{ $order->id }}) صدر قرار من
                        المحكم ({{ $order->firstJudger->name }} / الهوية: {{ $order->firstJudger->id_number }} / العنوان: {{ $order->firstJudger->address }} / المؤهل: {{ $order->firstJudger->qualification?->name }} / الهاتف: {{ $order->firstJudger->phone }} / البريد: {{ $order->firstJudger->email }})  المحال ﺇﻟﻴﻪ التحكيم وذلك ﺇﻟﻜﺘﺮﻭﻧﻴﺎ في منصة ووفق
                        ما ذكر في شرط
                        التحكيم في المادة () الواردة في عقد المحاماة المؤرخ بتاريخ {{ $order->created_at->format('Y-m-d') }} المبرم بين اطراف النزاع اعلاه و
                        الذي نص عليه ان :"........." والمرفق طيه في الحكم وفي منصة ايثاق, وحيث ان موضوغ النزاع في ({{ $order->title }})
                        وتتلخص
                        و قائعها كالاتي:
                    </p>
                    <br>
                    <p class="mb-1">الوقائع</p>
                    <div class="mb-2 d-flex align-items-center gap-1">
                        <div class="line-text">
                            @{{ summary }}
                        </div>
                    </div>

                    <p class="mb-1">الأسباب</p>
                    <div class="mb-2 d-flex align-items-center gap-1">
                        <div class="line-text">
                            @{{ reasons }}
                        </div>
                    </div>
                    <p>

                        <h6>منطوق الحكم</h6>

                        <div class="line-text">
                            @{{ judgment }}
                        </div>
                        <br>
                        <p class="text-center"> وﺍﻟﻠﻪ الموفق والهادي الي سواء السبيل, وصلي ﺍﻟﻠﻪ علي نبينا محمد وعلي اله وصحبه وسلم
                            </p>
                    <br>
                    <p class="text-start">توقيع المحكم </p>
                    <div class="html2pdf__page-break"></div>
                </section>
