<?php

namespace Database\Seeders;

use App\Models\WebsitePage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsitPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WebsitePage::truncate();
        $website_pages = array(
            array('id' => '1','title' => 'سياسات الموقع','slug' => 'policies','content' => '<p>سس</p>','status' => '1','created_at' => '2022-10-09 19:13:17','updated_at' => '2022-10-09 19:13:17'),
            array('id' => '2','title' => 'شروط الاستخدام','slug' => 'shrot-alastkhdam','content' => '<p dir="RTL" style="text-align:center"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">شروط الاستخدام</span></span></span></span></span></p>

          <p dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif">&nbsp;</span></span></p>

          <p dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif">&nbsp;</span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif">&nbsp;</span></span></p>

          <ul>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">التعريفات</span></span></span></span></span></li>
          </ul>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">المنصة: هي الموقع الالكتروني والتطبيقات المسماه بـ (موثوق) التابعة لـ شركة موثوق لخدمات الأعمال ومقرها الرياض.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">المستخدم: هو العميل أو المحامي أو المحكم- العضو وغير العضو- الناشئ له حساب شخصي في المنصة مراعياً فيها شروطها وضوابطها.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">المحكم العضو: هو المحكم الذي لديه حساب بالمنصة ومطابق عليه شروط العضوية ويستطيع المستخدمين -المحامي والعميل- إحالة النزاعات إليه مع تمتعه بمزايا المنصة، فاستمراره بالمنصة دائماً مع مراعاته لضوابطها وشروطها.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">المحكم الغير عضو: المحكم الذي تم جلبه من خارج المنصة عن طريق المستخدمين -المحامي والعميل- ويمارس عمله على ذات النزاع المحال اليه من قبلهم فقط دون اطلاعه على النزاعات الموجودة بالمنصة فاستمراره مؤقتاً مع مراعاة الضوابط والشروط لدى المنصة. </span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">العميل: المستخدم للمنصة من طالب الخدمات القانونية.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">المحامي: هو من يمارس مهنة المحاماة وفقاً لنظام المحاماة ولائحته المعمول بها في المملكة العربية السعودية.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">الحساب:</span></span></span> <span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">هو الصفحة/السجل الخاص بالمستخدم لأجل الاستفادة من خدمات منصة موثوق.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">القوة القاهرة: يقصد بها الحدث العام الذي يخرج عن سيطرة طرفي العقد ولا يمكن توقعه ويستحيل دفعه ويستحيل معه تنفيذ المتعاقد لالتزاماته أثناء قيامها.</span></span></span></span></span></p>

          <ul>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">المقدمة&nbsp;</span></span></span></span></span></li>
          </ul>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">تعتبر المنصة وسيطاً إلكترونياً بين المستخدمين ومن خلالها يتم منح الصلاحية للمستخدمين لإبرام العقود وتنفيذ الأعمال ودفع المستحقات وحفظها لدى المنصة لتسهيل تنفيذ الخدمات القانونية المتمثلة في التمثيل القضائي والقانوني والاستشارات والدراسات وكتابة العقود والمذكرات من قِبل المحامين المشتركين في المنصة وتوفير ما يسهل تلك الخدمات والسعي على أن تكون تلك الخدمات بأفضل معايير الجودة والإنجاز، فمنصة موثوق لا تقدم أي استشارات أو خدمات قانونية بل يتم تقديمها من قبل محامين يتم التحقق من وثائقهم مع تعهدهم بصحة البيانات والوثائق التي تم تقديمها للمنصة وفي حال تبين للمستخدم غير ذلك يجب عليه إفادة المنصة لاتخاذ الإجراءات بحقه.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">منصة موثوق مملوكة لشركة موثوق لخدمات الأعمال مقرها الرياض حي الصحافة طريق الملك عبدالعزيز، عنوان البريد الإلكتروني للتواصل ( </span></span></span><a href="mailto:info@reliable.sa"><span dir="LTR" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:#1155cc">info@reliable.sa</span></span></span></a><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black"> )</span></span></span></span></span></p>

          <ul>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">شـروط الـعـضـويـة</span></span></span></span></span></li>
          </ul>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">١-يلتزم العضو بعدم إنشاء أكثر من حساب عضوية في المنصة، لا لذات صفة المستخدم أو غيره من الصفات على سبيل المثال: لا يقبل أن يكون مقدم الخدمة كمحامي له عضوية أخرى كعضوية العميل وعضوية المحكم.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٢-يجب أن يكون المستخدم متمتعاً بالأهلية الكاملة وأن يكون قد بلغ من العمر اثنان وعشرون سنة هجرية.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٣- يلتزم العضو بتقديم جميع ما تطلبه المنصة من وثائق لقبوله كعضو في المنصة وعلى سبيل المثال لا الحصر:</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">الهوية أو جواز السفر، رخصة ممارسة النشاط، المؤهلات العلمية وغيرها.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٤-يلتزم المستخدم عند تفويض أو توكيل الغير له بأخذ تفويض وإذن رسمي من أصحاب العلاقة وإرفاقه في المنصة للقبول أو الرفض ولا يخلي ذلك من مسؤولية المفوِض أو الموكل ويتحمل ما قد يصيبه من أضرار.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٥-يلتزم المستخدم بجميع الوثائق المقدمة من المنصة كعقد المحاماة الموحد وقالب حكم التحكيم واللائحة التحكيمية لمنصة موثوق وسياسة الخصوصية وشروط الاستخدام وجميع مايطرأ على المنصة من إضافة أو تعديلات عليها.</span></span></span></span></span></p>

          <ul>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">أحــكــام عــامــة</span></span></span></span></span></li>
          </ul>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">١-يوافق المستخدم على الدخول للمنصة واستخدامها لأغراض مشروعة في المجال القانوني وعدم إساءة استخدامها بأي شكلٍ كان.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٢-يمتنع المستخدم عن الإعلان أو عرض أو بيع أي بضائع خلال المنصة كما يمتنع عن إرسال أي دراسات استقصائية أو إحصائيات أو مسابقات أو ترويج أو نشر أو توثيق أي أخبار أو أحداث من خلال المنصة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٣-يلتزم المستخدم بالامتناع عن أي عمليات تزوير أو تحريف أو تغيير على أي من أصول أو مصادر البرامج أو البرمجيات أو المواد أو المعلومات أو الوثائق أو البيانات أو التقارير التي تحتويها المنصة أو أي من المرفقات والمستندات والمعلومات التي يقوم المستخدم برفعها أو تحميلها أو تسجيلها على المنصة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٤-عدم استخدام المنصة لنشر محتوى غير قانوني بما في ذلك محتوى يتضمن العنصرية أو التعدي على الآخرين أو الازعاج أو أي محتوى آخر يمس الشريعة الإسلامية أو الأنظمة السياسية أو ارتكاب جريمة أو تشجيع الغير على القيام بأي من الأعمال التي تعد جرائم أو مخالفات وفقاً لأنظمة المملكة العربية السعودية.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٥-عدم استخدام المنصة لتحميل أي محتوى يتضمن فيروسات أو ملفات أو برامج أو أدوات قد تسبب ضرراً أو تعيق عمل المنصة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٦-عدم الإخلال أو نشر أي مواد تخل بحقوق ملكية الفكرية للآخرين أو بحقوق المنصة أو التعدي على براءة الاختراع أو علامة تجارية أو حقوق طبع أو نشر وعدم حفظ أو جمع المعلومات الشخصية عن الآخرين.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٧-عدم انتحال شخصية الغير أو تمثيل عن الغير ما لم يكن هناك إذن رسمي لاستخدام المنصة نيابةً عنها.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٨-يلتزم كل من المستخدمين بالأنظمة المرعية بالمملكة العربية السعودية وذلك على سبيل المثال نظام التحكيم ونظام المحاماة واللوائح والتعاميم.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٩- يلتزم كل من المستخدمين بصحة البيانات سواء تم إدخالها من قبله أو تم جلبها من طرف ثالث وتعديل ما يتم استحداثه من تلك البيانات.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">١٠-يلتزم المستخدمين بإجراء سداد المستحقات المالية عند التقديم على الخدمات القانونية ويتم حفظها كوديعة عند المنصة وذلك من خلال قنوات الدفع المعتمدة لدى المنصة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">١١- يلتزم المستخدمين بشروط الاستخدام وسياسة الخصوصية وعقد المحاماة واللائحة التحكيمية وكل ما يتم تزويد المستخدمين من قوالب موحدة للالتزام بها في المنصة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">١٢-يلتزم المستخدمين بمسؤولية المحافظة على سرية اسم المستخدم وكلمة المرور وترتب كامل المسؤولية على صاحب الحساب عن إعطائه صلاحية الدخول إلى الحساب لأي شخص ثالث سواء وكيل أو موظف أو غيره، مع مسؤوليته عما قد يترتب على ذلك من أضرار أو إفشاء المعلومات السرية ومنها معلومات الدخول.</span></span></span></span></span></p>

          <ul>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">إخلاء المسؤولية</span></span></span></span></span></li>
          </ul>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">١-لا تكون المنصة مسؤولة عن تخزين بيانات أطراف المستخدمين في حال تبادل تلك البيانات خارج المنصة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٢- لا تتحمل المنصة أي مبالغ محولة بين المستخدمين خارج المنصة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٣- لا تتحمل المنصة مسؤولية تخزين البيانات بعد ( ستة أشهر) من تاريخ رفعها أو من تاريخ انتهاء الخدمة المقدمة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٤- لا تتحمل المنصة أي تعويضات أو خسائر أو أضرار تصيب المستخدم بسبب تعاقداته أو مخالفته لسياسة الخصوصية أو شروط الاستخدام.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٥- لا تتحمل المنصة أي ضرر أو خسارة ناجمة عن الفيروسات التي تؤثر على جهازك الخاص أو برامجه التي تحصل عند استخدامك للمنصة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٦- لا تقدم المنصة أي تعهدات أو ضمانات بشأن المعلومات أو البيانات المتضمنة في المنصة ولا عن أي خطأ أو إهمال أو تحديث معلومات من المستخدمين.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٧- لا تتحمل المنصة أي مصروفات مالية وذلك على سبيل المثال لا الحصر : التكاليف القضائية ، أتعاب المحامين ، أتعاب المحكمين، وأي مصروفات مالية أخرى ناتجة عن استخدام المنصة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٨-لا يعتبر محتوى المنصة ومعلومات المستخدمين بمثابة توصية أو كفاءة أو ترشيح من المنصة فهي لا تتحمل مسؤولية دقة الخدمة المقدمة.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">سياسة الدفع والاسترداد:</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">للمنصة نسبة استحقاق مئوية للدفع والاسترداد يتم الإفصاح عنها وبيانها بالتفصيل في العقد المبرم عبر المنصة من قبل أطراف العقد، تستحق من تاريخ تنفيذ العقد وإيداع المبلغ إلى صاحبه وفقاً للشروط والأحكام الواردة في العقد.</span></span></span></span></span></p>

          <ul>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">إيقاف الاستخدام:</span></span></span></span></span></li>
          </ul>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:#212529">يحق للمنصة وفق تقديرها المطلق إيقاف المؤقت أو الدائم لحساب المستخدم عند انتهاك حقوقها الملكية أو مخالفة شروط الاستخدام أو سياسة الخصوصية أو غيرها من المخالفات مع اتخاذ الإجراءات القانونية إن استوجب ذلك.&nbsp;</span></span></span></span></span></p>

          <ul>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif">الملكية الفكرية:</span></span></span></span></li>
          </ul>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="background-color:white"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">١-المنصة تشمل على عدة عناصر للملكية الفكرية ومنها علاماتها التجارية و تقنياتها المستخدمة آلية وخطوات إجراءات الربط والوساطة بين المستخدمين والحقوق الأخرى التي كفلتها الأنظمة المرعية بالمملكة العربية السعودية فعليه، فالمنصة لا تمنح أي إذن لاستخدام ما يتعلق بملكيتها الفكرية أو ما يمثلها بأي شكل من الأشكال القانونية وأي اعتداء على حقوق الملكية للمنصة ستحتفظ المنصة بكافة حقوقها ضد مرتكب العمل غير المشروع، ويسري هذا الأمر وتلك الملكية طيلة فترة سريان استخدام المنصة أو عدم استخدامها أو إغلاقها أو انقضائها أو انتهاءها، وللمنصة في حال تبين لها أي شخص طبيعي أو اعتباري قد أخل بحكم هذه المادة في أي وقتٍ أن تطلب من أخل بذلك بدفع الأتعاب الفنية والمهنية والقيمة التجارية نظير إخلاله بهذا الحكم.</span></span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="background-color:white"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٢-أي نشاط يقوم به المستخدم في المنصة فأنه يمنح ملكية المنصة الحصرية في بيانات تلك الأعمال ويستثنى من ذلك ما تتضمنه تلك الأعمال من محتوى حيث أن المحتوى تعود ملكيته ومسؤوليته إلى صاحبها ولا علاقة للمنصة بالاحتفاظ بها وملكيتها.</span></span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="background-color:white"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">التعديلات</span></span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="background-color:white"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">&nbsp;تحتفظ المنصة بحقها في تعديل شروط الاستخدام</span></span></span></span><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black"> من حين لآخر وفقاً لإرادتها المنفردة ووفقاً لما تراه من أجل تحسين العمل والخدمة داخل المنصة دون أدنى مسئولية عليها، وستكون خاضعاً لتلك التعديلات السارية في وقت استخدامك للمنصة لذا يرجى مراجعة شروط الاستخدام من حين لآخر حتى تكون على إحاطةً بها وفي حال بطلان أو إلغاء أو عدم سريان أي من شروط الاستخدام يعتبر ذلك الشرط مستقل ولا يؤثر على صحة أو سريان بقية الشروط.</span></span></span></span></span></p>

          <ul>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">القوة القاهرة</span></span></span></span></span></li>
          </ul>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">في حال حدوث أي حالة من حالات القوة القاهرة التي تمنع المنصة من أداء أي عمل لديها يتم إشعار المستخدمين عبر ما يمكنها الوصول إليهم بأي طريقة من طرق التواصل حتى وإن كانت بغير البيانات المسجلة لديها، وذلك لإشعارهم بسبب تخلف أداء عملها لأي نشاط لها، ومن ضمن تلك الظروف على سبيل المثال لا الحصر:&nbsp;</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">1- الكوارث الطبيعية من زلازل وتفشي الأمراض وغيرها.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">2- الظروف السياسية من حروب وغيرها.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">٣- الظروف التقنية مثل الأعطال والاختراق الأمني وغيرها مما له علاقة بالتقنية.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">وفي حال حدوث أي قوة قاهرة للمستخدمين وأرادوا الاحتجاج بها لأغراض تتعلق بتعاملاتهم في المنصة، فيجب عليهم إثبات ذلك والإشعار بها خلال 5 أيام عمل، لدى المنصة إن كانت متعلقة بأعمال المنصة فقط، ولدى المحكم إن كانت متعلق بالعقد المبرم بين المستخدمين، ومع ذلك كله على المستخدم اتخاذ التدابير اللازمة لاستكمال ما يلزمه من التزامات في جانبه لتنفيذ ما طلب منه وإخلاء مسؤوليته، وفي حال نتج عن ذلك أي تكاليف مالية أو غيره فإن ذلك من مهام والتزامات المحكم للفصل فيها.</span></span></span></span></span></p>

          <ul>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">الشكاوى</span></span></span></span></span></li>
          </ul>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">تسعى المنصة دائماً إلى تحسين وتطوير الخدمات المقدمة من خلالها، وتسهيلاً على المستخدمين تم إدراج هذه السياسة على وجه التحديد والخصوص في شأن الطلبات التي تقدم وما يتم عليها من إجراءات قبل التعاقد بين المستخدمين، ومن أجل تقديم خدمة الوساطة والربط على أكمل وجه بالإضافة إلى توفير قناة تواصل فعالة مع المستخدمين وذلك من خلال التالي:</span></span></span></span></span></p>

          <ol>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">التقدم بالشكوى خلال (3) أيام عمل من حدوثها عن طريق الايميل الرسمي الخاص في الشكاوى لدى المنصة وإلا فإن صاحبها يتنازل عن الحق في تقديم الشكوى.</span></span></span></span></span></li>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">التحقيق في الشكوى سيتم بكل شفافية ونزاهة عبر الايميل الخاص بالشكاوى للمنصة والايميل الرسمي</span></span></span></span></span></li>
          </ol>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">للمستخدمين.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">3- سيتم العمل على الشكوى خلال (5) أيام عمل من تاريخ تقديمها، وفي حال تطلبت الشكوى مزيداً من</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">الدراسة سيتم إخطارهم بذلك.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">4- في حال كانت الشكوى على أحد موظفين المنصة فإنه يجب على صاحب الشكوى أن يرفع شكواه لدى إدارة المنصة عبر الايميل الرسمي ( </span></span></span><span dir="LTR" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">info@reliable.sa</span></span></span><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">) قبل أي جهة أخرى للنظر فيها واتخاذ ما يلزم لدى المنصة، ويمكنك متابعة الشكوى عبر الايميل المشار إليه آنفاً.</span></span></span></span></span></p>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">5-&nbsp; تم إدراج (</span></span></span><span dir="LTR" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">info@reliable.sa</span></span></span><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">) خاص بالشكاوى تسهيلاً على المستفيدين، ويمكنك متابعة الشكوى عبر الايميل المشار إليه آنفاً.</span></span></span></span></span></p>

          <ul>
              <li dir="RTL" style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">حل النزاعات</span></span></span></span></span></li>
          </ul>

          <p dir="RTL" style="margin-left:-23px; margin-right:-28px; text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span dir="ltr" lang="AR-SA" style="font-size:14.0pt"><span style="background-color:white"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">في حال نشوء أي نزاع بين المستخدم والمنصة فقط، وكان ذلك النزاع المنصة طرفاً فيه مما ينشأ عنها أو بسببها من حقوق والتزامات، فإن الطرفين يتعهدان بحل النزاع بالطرق الودية خلال مدة أقصاها (١٥) خمسة عشر يوماً منذ نشوء النزاع، وفي حال تعذر حل النزاع بالطرق الودية؛ عندئذٍ يكون تسويتها عن طريق التحكيم ويديرها المركز السعودي للتحكيم التجاري وفق قواعد التحكيم لديه.</span></span></span></span></span></span></p>

          <p><span dir="RTL" lang="AR-SA" style="font-size:14.0pt"><span style="background-color:white"><span style="font-family:&quot;Arial&quot;,sans-serif"><span style="color:black">- بموافقتك على شروط الاستخدام فأنت تقر على فهمها واستيعاب جميع ما تضمنته وتتعهد بالالتزام بها وإبراء ذمة المنصة من أي التزامات أو مطالبات تلحق بك أو بالمستخدمين.&nbsp;</span></span></span></span></p>','status' => '1','created_at' => '2022-10-17 08:03:02','updated_at' => '2022-10-17 08:03:02')
          );

          foreach($website_pages as $p){
            WebsitePage::create($p);
          }
    }
}
