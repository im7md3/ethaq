<div class="d-none d-lg-block col-lg-3">

  <div class="slide-user">

    <div class="card-slide">
      <img class="img-user" src="{{ display_file($user->photo) }}" alt="" />
      <h6 class="">
        {{ $user->name }}
      </h6>
      <div class="badge-info">{{ $user->occupation?->name??'لا يوجد' }}</div>
    </div>
    <div class="card-slide ">
      <div class="d-flex flex-column gap-2">
{{--         <a href="{{ route('vendor.consulting.index') }}" class="btn-blue-slide">
            الاستشارات الجديدة
        </a>
        <a href="{{ route('vendor.myConsulting') }}" class="btn-blue-slide">
          استشارات تحت التنفيذ
        </a> --}}
        {{-- <a href="#" class="btn-blue-slide" data-bs-toggle="tooltip" data-bs-placement="top"
          data-bs-custom-class="custom-tooltip" data-bs-title="تعتبر خدمة االاستشارات متاحة لكل المحامين وهي الان تعمل بشكل تدريجي وسيكون هناك قنوات وتواصل اكثر ويمكن للمحامي ايقاف الخدمي في أي وقت
او الاشتراك واختيار الاقسام المناسبة لة مع مراجعة الشروط والاحكام للموقع">
          عن الخدمة
        </a> --}}
        سعر الاستشارة لديك: {{ $user->consulting_price }} ريال
        <a href="{{ route('vendor.settings') }}"
          class="btn-blue-slide">
          تعديل
        </a>
      </div>
    </div>
  </div>
</div>
