@extends('layouts.pdf')

@section('content')
<div class="clearfix">
    <div class="text-center">
        <b>Invoice {{ $invoice->invoice_number }}</b>
        <br>
        {{ $invoice->invoice_date }}
    </div>
</div>

<div class="clearfix mt-3">
    <div class="float-left">
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

    <div class="float-right">
        <b>From</b>: {{ Auth::user()->name }}

        <br><br><b>Address</b>: {{ Auth::user()->address }}

        <br><b>Email</b>: {{ Auth::user()->email }}
        <br><b>Email</b>: {{ Auth::user()->phone }}
    </div>
</div>

<div class="clearfix mt-3">
    <table class="table table-bordered">
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


<div class="row clearfix" style="margin-top:20px">
                        <div class="col-md-12">
                            <div class="float-right col-md-7">
                                <table class="table table-bordered table-hover" id="tab_logic_total">
                                    <tbody>
                                        <tr>
                                            <th class="text-center" width="50%">Sub Total(&#8358;)</th>
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

<div class="clearfix mt-3 text-center">
    <h4>Invoice must be paid within 30 days</h4>
</div>
@endsection
