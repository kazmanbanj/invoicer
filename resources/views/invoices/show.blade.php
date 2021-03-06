@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Invoice number {{ $invoice->invoice_number }}</div>

                <div class="card-body">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-4 offset-4 text-center">
                            <b>Invoice {{ $invoice->invoice_number }}</b>
                            <br>
                            {{ $invoice->invoice_date }}
                            <br>
                        </div>
                    </div>
                        <div class="row clearfix" style="margin-top:20px">
                            <div class="col-md-12">
                                <div class="float-left col-md-6">
                                    <b>To:</b> {{ $invoice->customer->name }}

                                    <br><b>Address</b>: {{ $invoice->customer->address }}

                                    @if ($invoice->customer->postcode != '')
                                    <br><b>Postcode</b>: {{ $invoice->customer->postcode }}
                                    @endif

                                    <br><b>City</b>: {{ $invoice->customer->city }}

                                    @if ($invoice->customer->state != '')
                                        <br><b>State</b>: {{ $invoice->customer->state }}
                                    @endif

                                    <br><b>Country</b>: {{ $invoice->customer->country->title }}

                                    @if ($invoice->customer->phone != '')
                                        <br><b>Phone</b>: {{ $invoice->customer->phone }}
                                    @endif

                                    @if ($invoice->customer->email != '')
                                        <br><b>Email</b>: {{ $invoice->customer->email }}
                                    @endif

                                    @if ($invoice->customer->customer_fields)
                                        @foreach($invoice->customer->customer_fields as $field)
                                            <br><b>{{ $field->field_key }}</b>: {{ $field->field_value }}
                                        @endforeach
                                    @endif
                                </div>
                                <div class="float-right col-md-4">
                                    <b>From</b>: {{ Auth::user()->name }}

                                    <br><br><b>Address</b>: {{ Auth::user()->address }}

                                    <br><b>Email</b>: {{ Auth::user()->email }}
                                    <br><b>Email</b>: {{ Auth::user()->phone }}
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix" style="margin-top:20px">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover" id="tab_logic">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> # </th>
                                            <th class="text-center"> Product </th>
                                            <th class="text-center"> Qty </th>
                                            <th class="text-center"> Price(&#8358;)</th>
                                            <th class="text-center"> Total(&#8358;)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($invoice->invoice_items as $item)
                                        <tr id='addr0'>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix" style="margin-top:20px">
                            <div class="col-md-12">
                                <div class="float-right col-md-5">
                                    <table class="table table-bordered table-hover" id="tab_logic_total">
                                        <tbody>
                                        <tr>
                                            <th class="text-center" width="60%">Sub Total(&#8358;)</th>
                                            <td class="text-center">{{ number_format($invoice->total_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Tax</th>
                                            <td class="text-center">{{ $invoice->tax_percent }}%</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Tax Amount(&#8358;)</th>
                                            <td class="text-center">{{ number_format($invoice->total_amount * $invoice->tax_percent / 100, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Grand Total(&#8358;)</th>
                                            <td class="text-center">{{ number_format($invoice->total_amount + ($invoice->total_amount * $invoice->tax_percent / 100), 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix text-center" style="margin-top: 20px">
                        <div class="col-md-12 text-center">
                            <h4>Invoice must be paid within 30 days</h4>
                        </div>
                    </div>
                </div>
        <div class="text-center py-2"><a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-warning">Download PDF</a></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var i = 1;
    $("#add_row").click(function() {
        b = i - 1;
        $('#addr' + i).html($('#addr' + b).html()).find('td:first-child').html(i + 1);
        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        i++;
    });
    $("#delete_row").click(function() {
        if (i > 1) {
            $("#addr" + (i - 1)).html('');
            i--;
        }
        calc();
    });

    $('#tab_logic tbody').on('keyup change', function() {
        calc();
    });
    $('#tax').on('keyup change', function() {
        calc_total();
    });


});

function calc() {
    $('#tab_logic tbody tr').each(function(i, element) {
        var html = $(this).html();
        if (html != '') {
            var qty = $(this).find('.qty').val();
            var price = $(this).find('.price').val();
            $(this).find('.total').val(qty * price);

            calc_total();
        }
    });
}

function calc_total() {
    total = 0;
    $('.total').each(function() {
        total += parseInt($(this).val());
    });
    $('#sub_total').val(total.toFixed(2));
    tax_sum = total / 100 * $('#tax').val();
    $('#tax_amount').val(tax_sum.toFixed(2));
    $('#total_amount').val((tax_sum + total).toFixed(2));
}
</script>
@stop
