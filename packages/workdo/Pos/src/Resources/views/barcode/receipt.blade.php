@php
    $admin_settings = getAdminAllSetting();
    $company_settings = getCompanyAllSetting();
    $favicon = isset($company_settings['favicon']) ? $company_settings['favicon'] : (isset($admin_settings['favicon']) ? $admin_settings['favicon'] : 'uploads/logo/favicon.png');
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{$company_settings['site_rtl'] == 'on'?'rtl':''}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ check_file($favicon) ? get_file($favicon) : get_file('uploads/logo/favicon.png')  }}{{'?'.time()}}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">

    <title>{{__('POS Barcode')}} | {{ !empty($company_settings['title_text']) ? $company_settings['title_text'] : (!empty($admin_settings['title_text']) ? $admin_settings['title_text'] :'HUBKOLO') }}</title>
    @if (isset($company_settings['site_rtl'] ) && $company_settings['site_rtl'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css')}}" id="main-style-link">
    @endif
    <style>
        .sticky-print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            padding: 15px 30px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .sticky-print-button:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        @media print {
            .sticky-print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
<div id="bot" class="mt-5">
    <div class="row">
        @foreach($productServices as $product)
            @php
                // Calculate quantity based on type
                $printQuantity = $request->quantity_type === 'auto' ? $product->quantity : $quantity;
            @endphp
            @for($i=1;$i<=$printQuantity;$i++)
                <div class="col-auto mb-2">
                    <small class="">{{$product->name}} @if($request->quantity_type === 'auto')({{$i}} of {{$printQuantity}})@endif</small>
                    <div data-id="{{$product->id}}" class="product_barcode product_barcode_hight_de product_barcode_{{$product->id}} mt-2" data-warehouse="{{ $product->warehouse_id }}" data-skucode="{{ $product->sku }}"></div>
                </div>
            @endfor
        @endforeach
    </div>
</div>

<button class="sticky-print-button" onclick="printAndBack()">
    <i class="ti ti-printer"></i> {{__('Print')}}
</button>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('packages/workdo/Pos/src/Resources/assets/js/jquery-barcode.min.js') }}"></script>
<script src="{{ asset('packages/workdo/Pos/src/Resources/assets/js/jquery-barcode.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".product_barcode").each(function() {
            var id = $(this).data("id");
            var sku = $(this).data('skucode');
            var warehouse = $(this).data('warehouse');
            sku = encodeURIComponent(sku);
            generateBarcode(sku, id);
        });
    });
    
    function generateBarcode(val, id) {
        var value = val;    
        var btype = '{{ $barcode['barcodeType'] }}';
        var renderer = '{{ $barcode['barcodeFormat'] }}';
        var settings = {
            output: renderer,
            bgColor: '#FFFFFF',
            color: '#000000',
            barWidth: '1',
            barHeight: '50',
            moduleSize: '5',
            posX: '10',
            posY: '20',
            addQuietZone: '1'
        };
        $('.product_barcode_' + id).html("").show().barcode(value, btype, settings);
    }

    function printAndBack() {
        window.print();
        window.onafterprint = function() {
            window.close();
            window.history.back();
        };
    }
</script>
</body>
</html>
