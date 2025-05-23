@extends('layouts.main')
@section('page-title')
    {{__('Manage POS Barcode Print')}}
@endsection
@section('page-breadcrumb')
    {{__('Product Barcode')}},
    {{__('POS Barcode Print')}}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('packages/workdo/Pos/src/Resources/assets/css/buttons.dataTables.min.css') }}">
    <style>
        #manual_quantity_div {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var b_id = $('#warehouse_id').val();
            getProduct(b_id);
            
            // Handle quantity type change
            $('#quantity_type').on('change', function() {
                if($(this).val() === 'manual') {
                    $('#manual_quantity_div').slideDown();
                    $('#quantity').prop('required', true);
                } else {
                    $('#manual_quantity_div').slideUp();
                    $('#quantity').prop('required', false);
                }
            });

            // Trigger change event on page load to set initial state
            $('#quantity_type').trigger('change');
        });
        
        $(document).on('change', 'select[name=warehouse_id]', function () {
            var warehouse_id = $(this).val();
            getProduct(warehouse_id);
        });

        function getProduct(bid) {
            $.ajax({
                url: '{{route('pos.getproduct')}}',
                type: 'POST',
                data: {
                    "warehouse_id": bid, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#product_id').empty();
                    $("#product_div").html('');
                    $('#product_div').append('<label for="product_id" class="form-label">{{__('Product')}}</label><span class="text-danger">*</span>');
                    $('#product_div').append('<select class="form-label" id="product_id" name="product_id[]"  multiple></select>');
                    $('#product_id').append('<option value="">{{__('Select Product')}}</option>');

                    $.each(data, function (key, value) {
                        $('#product_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    var multipleCancelButton = new Choices('#product_id', {
                        removeItemButton: true,
                    });
                }
            });
        }
    </script>
    <script>
        function copyToClipboard(element) {
            var copyText = element.id;
            navigator.clipboard.writeText(copyText);
            show_toastr('success', 'Url copied to clipboard', 'success');
        }
    </script>
    <script>
        var filename = $('#filesname').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
@endpush

@section('page-action')
    <div class="float-end">
        <a href="{{ route('pos.barcode') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Back')}}">
            <i class="ti ti-arrow-left text-white"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{Form::open(array('route'=>'pos.receipt','method'=>'post','class'=>'needs-validation','novalidate'))}}
                        <div class="row" id="printableArea">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {{Form::label('warehouse_id',__('Warehouse'),['class'=>'form-label'])}}<x-required></x-required>
                                    {{ Form::select('warehouse_id', ['' => 'Select Warehouse'] + $warehouses->toArray(),null, array('class' => 'form-control select','id'=>'warehouse_id')) }}
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group" id="product_div">
                                    {{Form::label('product_id',__('Product'),['class'=>'form-label'])}}<x-required></x-required>
                                    <select class="form-control select" name="product_id[]" id="product_id" required >
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {{ Form::label('quantity_type', __('Quantity Type'),['class'=>'form-label']) }}<x-required></x-required>
                                    {{ Form::select('quantity_type', ['auto' => __('Auto (Product Stock Quantity)'), 'manual' => __('Manual Quantity') ], 'auto', ['class' => 'form-control select', 'id' => 'quantity_type', 'required' => 'required']) }}
                                </div>
                            </div>
                            <div class="col-lg-4" id="manual_quantity_div">
                                <div class="form-group">
                                    {{ Form::label('quantity', __('Manual Quantity'),['class'=>'form-label']) }}<x-required></x-required>
                                    {{ Form::number('quantity', 1, array('class' => 'form-control', 'id' => 'quantity', 'min' => '1')) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 pt-4">
                            <button class="btn btn-primary btn-icon float-end" type="submit"><i class="ti ti-printer text-white"></i> {{__('Print')}}</button>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection


