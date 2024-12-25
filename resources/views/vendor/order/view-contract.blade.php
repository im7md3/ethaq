@extends('vendor.layouts.vendor')
@section('title', $order->title)
@section('content')
    <div class="container my-5">
        @if ($order->contract_file != null)
            <a class="btn btn-outline-primary btn-sm px-5 mt-1 d-inline-flex" target="_blank"
                href="{{ display_file($order->contract_file) }}">تصدير</a>
        @else
            <button class="btn btn-outline-primary btn-sm px-5 mt-1 d-inline-flex" id="pdf-btn">تصدير</button>
        @endif

        @if (!$order->vendor_contract)
            <form action="{{ route('vendor.contract.vendor_accept', $order) }}" method="POST" class="d-inline-flex">
                @csrf
                <input type="hidden" name="vendor_contract" value="1">
                <button type="submit" class="btn btn-sm btn-primary px-3">موافقة وإرسال</button>
            </form>
        @endif
    </div>
    @if ($order->contract_file == null)
        <div id="printContract">
            @if ($order->without_judgers)
                <x-order.contract-without-judgers :order="$order"></x-order.contract-without-judgers>
            @else
                <x-order.contract :order="$order"></x-order.contract>
            @endif
        </div>
    @endif
    {{-- @if (!$order->vendor_contract)
  <form action="{{ route('vendor.contract.vendor_accept',$order) }}" method="POST">
  @csrf
  <input type="hidden" name="vendor_contract" value="1">
  <button type="submit" class="btn btn-sm btn-primary">موافقة وإرسال</button>
  </form>
  @endif --}}
    </div>

    @if ($order->contract_file == null)
        @push('js')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

            <script>
                function toPdf() {
                    var element = document.getElementById('printContract');
                    var opt = {
                        margin: [0.1, 0.1, 0.1, 0.1], //top, left, buttom, right
                        pagebreak: {
                            mode: ['avoid-all', 'css', 'legacy']
                        },
                        filename: "{{ 'عقد المحامااة رقم ' . $order->id }}",
                        image: {
                            type: 'jpeg',
                            quality: 0.98
                        },
                        html2canvas: {
                            scale: 2,
                            scrollY: 0
                        },
                        jsPDF: {
                            unit: 'in',
                            format: 'A3',
                            orientation: 'portrait'
                        }
                    };
                    html2pdf().set(opt).from(element).save();
                }
                document.getElementById("pdf-btn").addEventListener("click", toPdf);
            </script>
        @endpush
    @endif

@endsection
