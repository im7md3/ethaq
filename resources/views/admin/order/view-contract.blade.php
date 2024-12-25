@extends('admin.order.layout')
@section('title', $order->title)
@section('content')
    <div class="container my-5">
        @if ($order->contract_file != null)
            <a class="btn btn-primary mb-5" target="_blank" href="{{ display_file($order->contract_file) }}">تصدير</a>
        @else
            <button class="btn btn-primary mb-5" id="pdf-btn">تصدير</button>
        @endif
        {{-- <div id="printContract">
    {!! $order->contract !!}
</div> --}}
        @if ($order->contract_file == null)
            <x-order.contract :order="$order"></x-order.contract>
        @endif

    </div>
    @if ($order->contract_file == null)
        @push('js')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
                integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>

            <script>
                function toPdf() {
                    var element = document.getElementById('printContract');
                    var opt = {
                        margin: 0.1,
                        // pagebreak: { mode: ['avoid-all', 'css', 'legacy'] },
                        filename: 'myfile.pdf',
                        image: {
                            type: 'jpeg',
                            quality: 0.98
                        },
                        html2canvas: {
                            scale: 2
                        },
                        jsPDF: {
                            unit: 'in',
                            format: 'letter',
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
