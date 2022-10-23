@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('frontend/css/pickadate/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/pickadate/classic.date.css') }}">
    @if(config('app.locale') == 'ar')
        <link rel="stylesheet" href="{{ asset('frontend/css/pickadate/rtl.css') }}">
    @endif
    <style>
        form.form label.error, label.error {
            color: red;
            font-style: italic;
        }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h2>{{ __('Frontend/frontend.invoice', ['invoice_number' => $invoice->invoice_number]) }}</h2>
                    <a href="{{ route('invoices.index') }}" class="btn btn-primary ml-auto"><i class="fa fa-home"></i> {{ __('Frontend/frontend.back_to_invoice') }}</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('invoices.update', $invoice->id) }}" method="post" class="form">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="customer_name">{{ __('Frontend/frontend.customer_name') }}</label>
                                    <input type="text" name="customer_name" value="{{ old('customer_name', $invoice->customer_name) }}" class="form-control">
                                    @error('customer_name')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="customer_email">{{ __('Frontend/frontend.customer_email') }}</label>
                                    <input type="text" name="customer_email" value="{{ old('customer_email', $invoice->customer_email) }}" class="form-control">
                                    @error('customer_email')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="customer_mobile">{{ __('Frontend/frontend.customer_mobile') }}</label>
                                    <input type="text" name="customer_mobile" value="{{ old('customer_mobile', $invoice->customer_mobile) }}" class="form-control">
                                    @error('customer_mobile')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="company_name">{{ __('Frontend/frontend.company_name') }}</label>
                                    <input type="text" name="company_name" value="{{ old('company_name', $invoice->company_name) }}" class="form-control">
                                    @error('company_name')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="invoice_number">{{ __('Frontend/frontend.invoice_number') }}</label>
                                    <input type="text" name="invoice_number" value="{{ old('invoice_number', $invoice->invoice_number) }}" class="form-control">
                                    @error('invoice_number')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="invoice_date">{{ __('Frontend/frontend.invoice_date') }}</label>
                                    <input type="date" name="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date) }}" class="form-control">
                                    @error('invoice_date')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="invoice_details">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('Frontend/frontend.product_name') }}</th>
                                    <th>{{ __('Frontend/frontend.unit') }}</th>
                                    <th>{{ __('Frontend/frontend.quantity') }}</th>
                                    <th>{{ __('Frontend/frontend.unit_price') }}</th>
                                    <th>{{ __('Frontend/frontend.product_subtotal') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoice->details as $item)
                                <tr class="cloning_row" id="{{ $loop->index }}">
                                    <td>
                                        @if($loop->index == 0)
                                        {{ '#' }}
                                        @else
                                            <button type="button" class="btn btn-danger btn-sm delegated-btn"><i class="fa fa-minus"></i></button>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" name="product_name[{{ $loop->index }}]" id="product_name" value="{{ old('product_name', $item->product_name) }}" class="product_name form-control">
                                        @error('product_name')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                    </td>
                                    <td>
                                        <select name="unit[{{ $loop->index }}]" id="unit" class="unit form-control">
                                            <option></option>
                                            <option value="piece" {{ $item->unit == 'piece' ? 'selected' : '' }}>{{ __('Frontend/frontend.piece') }}</option>
                                            <option value="g" {{ $item->unit == 'g' ? 'selected' : '' }}>{{ __('Frontend/frontend.gram') }}</option>
                                            <option value="kg" {{ $item->unit == 'kg' ? 'selected' : '' }}>{{ __('Frontend/frontend.kilo_gram') }}</option>
                                        </select>
                                        @error('unit')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                    </td>
                                    <td>
                                        <input type="number" name="quantity[{{ $loop->index }}]" step="0.01" id="quantity" value="{{ old('quantity', $item->quantity) }}" class="quantity form-control">
                                        @error('quantity')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                    </td>
                                    <td>
                                        <input type="number" name="unit_price[{{ $loop->index }}]" step="0.01" id="unit_price" value="{{ old('unit_price', $item->unit_price) }}" class="unit_price form-control">
                                        @error('unit_price')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="row_sub_total[{{ $loop->index }}]" id="row_sub_total" value="{{ old('row_sub_total', $item->row_sub_total) }}" class="row_sub_total form-control" readonly="readonly">
                                        @error('row_sub_total')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>

                                <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <button type="button" class="btn_add btn btn-primary">{{ __('Frontend/frontend.add_another_product') }}</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">{{ __('Frontend/frontend.sub_total') }}</td>
                                    <td><input type="number" step="0.01" name="sub_total" id="sub_total" value="{{ old('sub_total', $invoice->sub_total) }}" class="sub_total form-control" readonly="readonly"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">{{ __('Frontend/frontend.discount') }}</td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <select name="discount_type" id="discount_type" class="discount_type custom-select">
                                                <option value="fixed" {{ $invoice->discount_type == 'fixed' ? 'selected' : '' }}>{{ __('Frontend/frontend.sr') }}</option>
                                                <option value="percentage" {{ $invoice->discount_type == 'percentage' ? 'selected' : '' }}>{{ __('Frontend/frontend.percentage') }}</option>
                                            </select>
                                            <div class="input-group-append">
                                                <input type="number" step="0.01" name="discount_value" id="discount_value" value="{{ old('discount_value', $invoice->discount_value) }}" class="discount_value form-control" value="0.00">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">{{ __('Frontend/frontend.vat') }}</td>
                                    <td><input type="number" step="0.01" name="vat_value" id="vat_value" value="{{ old('vat_value', $invoice->vat_value) }}" class="vat_value form-control" readonly="readonly"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">{{ __('Frontend/frontend.shipping') }}</td>
                                    <td><input type="number" step="0.01" name="shipping" id="shipping" value="{{ old('shipping', $invoice->shipping) }}" class="shipping form-control"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">{{ __('Frontend/frontend.total_due') }}</td>
                                    <td><input type="number" step="0.01" name="total_due" id="total_due" value="{{ old('total_due', $invoice->total_due) }}" class="total_due form-control" readonly="readonly"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="text-right pt-3">
                            <button type="submit" name="save" class="btn btn-primary">{{ __('Frontend/frontend.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="{{ asset('frontend/js/form_validation/jquery.form.js') }}"></script>
    <script src="{{ asset('frontend/js/form_validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('frontend/js/form_validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('frontend/js/pickadate/picker.js') }}"></script>
    <script src="{{ asset('frontend/js/pickadate/picker.date.js') }}"></script>
    @if (config('app.locale') == 'ar')
        <script src="{{ asset('frontend/js/pickadate/ar.js') }}"></script>
        <script src="{{ asset('frontend/js/form_validation/messages_ar.js') }}"></script>
    @endif
    <script>
        $(document).ready(function() {

            $('.pickdate').pickadate({
                format: 'yyyy-mm-dd',
                selectMonth: true,
                selectYear: true,
                clear: 'Clear',
                close: 'Ok',
                closeOnSelect: true
            });

            $('#invoice_details').on('keyup blur', '.quantity', function() {
                let $row = $(this).closest('tr');
                let quantity = $row.find('.quantity').val() || 0;
                let unit_price = $row.find('.unit_price').val() || 0;

                $row.find('.row_sub_total').val((quantity * unit_price).toFixed(2))

                $('#sub_total').val(sum_total('.row_sub_total'));
                $('#vat_value').val(calculate_vat());
                $('#total_due').val(sum_due_total());

            });

            $('#invoice_details').on('keyup blur', '.unit_price', function() {
                let $row = $(this).closest('tr');
                let quantity = $row.find('.quantity').val() || 0;
                let unit_price = $row.find('.unit_price').val() || 0;

                $row.find('.row_sub_total').val((quantity * unit_price).toFixed(2));

                $('#sub_total').val(sum_total('.row_sub_total'));
                $('#vat_value').val(calculate_vat());
                $('#total_due').val(sum_due_total());

            });

            $('#invoice_details').on('keyup blur', 'discount_type', function() {
                $('#vat_value').val(calculate_vat());
                $('#total_due').val(sum_due_total());
            });

            $('#invoice_details').on('keyup blur', '.discount_value', function() {
                $('#vat_value').val(calculate_vat());
                $('#total_due').val(sum_due_total());
            });

            $('#invoice_details').on('keyup blur', 'shipping', function() {
                $('#vat_value').val(calculate_vat());
                $('#total_due').val(sum_due_total());
            });

            let sum_total = function($selector) {
                let sum = 0;
                $($selector).each(function() {
                    let selectorVal = $(this).val() != '' ? $(this).val() : 0;
                    sum += parseFloat(selectorVal);

                });

                return sum.toFixed(2);
            }

            let calculate_vat = function() {
                let sub_totalVal = $('.sub_total').val() || 0;
                let discount_type = $('.discount_type').val();
                let discount_value = parseFloat($('.discount_value').val()) || 0;
                let discountVal = discount_value != 0 ? discount_type == 'percentage' ? sub_totalVal * (
                    discount_value / 100) : discount_value : 0;

                let vatVal = (sub_totalVal - discountVal) * 0.05;

                return vatVal.toFixed(2);
            }

            let sum_due_total = function() {
                let sum = 0;
                let sub_totalVal = $('.sub_total').val() || 0;
                let discount_type = $('.discount_type').val();
                let discount_value = parseFloat($('.discount_value').val()) || 0;
                let discountVal = discount_value != 0 ? discount_type = 'percentage' ? sub_totalVal * (
                    discount_value / 100) : discount_value : 0;

                let vatVal = parseFloat($('.vat_value').val()) || 0;
                let shippingVal = parseFloat($('.shipping').val()) || 0;

                sum += sub_totalVal;
                sum -= discountVal;
                sum += vatVal;
                sum += shippingVal;

                return sum.toFixed(2);
            }
            $(document).on('click', '.btn_add', function() {
                let trCount = $('#invoice_details').find('tr.cloning_row:last').length;
                let numberIncr = trCount > 0 ? parseInt($('#invoice_details').find('tr.cloning_row:last')
                    .attr('id')) + 1 : 0;

                $('#invoice_details').find('tbody').append($('' +
                    '<tr class="cloning_row" id=" ' + numberIncr + ' ">' +
                    '<td><button type="button" class="btn btn-danger btn-sm delgated-btn"><i class="fa fa-minus"></button></td>' +
                    '<td>' +
                    '<input type="text" name="product_name[' + numberIncr +
                    ']" class="product_name form-control">' +
                    '</td>' +
                    '<td>' +
                    '<select name="unit[' + numberIncr + ']" class="unit form-control">' +
                    '<option></option>' +
                    '<option value="piece">Piece</option>' +
                    '<option value="g">Gram</option>' +
                    '<option value="kg">Kilo Gram</option>' +
                    '</select>' +
                    '</td>' +
                    '<td>' +
                    '<input type="number" name="quantity[' + numberIncr +
                    ']" step="0.01" class="quantity form-control">' +
                    '</td>' +
                    '<td>' +
                    '<input type="number" name="unit_price[' + numberIncr +
                    ']" step="0.01" class="unit_price form-control">' +
                    '</td>' +
                    '<td>' +
                    '<input type="number" step="0.01" name="row_sub_total[' + numberIncr +
                    ']" class="row_sub_total form-control" readonly="readonly">' +
                    '</td>' +
                    '</tr>'));
            });

            $(document).on('click', '.delgated-btn', function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
                $('#sub_total').val(sum_total('.row_sub_total'));
                $('#vat_value').val(calculate_vat());
                $('#total_due').val(sum_due_total());
            });

            $('form').on('submit', function(e) {
                $('input.product_name').each(function() {
                    $(this).rules("add", {
                        required: true
                    });
                });
                $('select.unit').each(function() {
                    $(this).rules("add", {
                        required: true
                    });
                });
                $('input.quantity').each(function() {
                    $(this).rules("add", {
                        required: true
                    });
                });
                $('input.unit_price').each(function() {
                    $(this).rules("add", {
                        required: true
                    });
                });
                $('input.row_sub_total').each(function() {
                    $(this).rules("add", {
                        required: true
                    });
                });
                e.preventDefault();
            });

            $('form').validate({
                rules: {
                    'customer_name': {
                        required: true
                    },
                    'customer_email': {
                        required: true,
                        email: true
                    },
                    'customer_mobile': {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    'company_name': {
                        required: true,
                    },
                    'invoice_number': {
                        required: true,
                        digits: true
                    },
                    'invoice_date': {
                        required: true
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

        });
    </script>
@endsection
