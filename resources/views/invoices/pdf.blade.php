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

            <br><b>Country</b>: {{ $invoice->customer->country }}

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
                <th> Product </th>
                <th class="text-center"> Qty </th>
                <th class="text-center"> Price (&#8358;) </th>
                <th class="text-center"> Total (&#8358;) </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($invoice->invoice_items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-center">{{ $item->price }}</td>
                    <td class="text-center">{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <div class="clearfix mt-3">
        <table class="float-right table tbl-total">
            <tbody>
            @if ($invoice->tax_percent > 0)
                <tr>
                    <th class="text-right">Sub Total (&#8358;):</th>
                    <td class="text-left">
                        {{ number_format($invoice->total, 2) }}
                    </td>
                </tr>
                <tr>
                    <th class="text-right">Tax:</th>
                    <td class="text-left">
                        {{ $invoice->tax_percent }}%
                </tr>
                <tr>
                    <th class="text-right">Tax Amount (&#8358;):</th>
                    <td class="text-left">
                        {{ number_format($invoice->total * $invoice->tax_percent / 100, 2) }}
                    </td>
                </tr>
            @endif
            <tr>
                <th class="text-right">Grand Total (&#8358;):</th>
                <td class="text-left">
                    @if ($invoice->tax_percent > 0)
                        {{ number_format($invoice->total * (1 + $invoice->tax_percent / 100), 2) }}
                    @else
                        {{ number_format($invoice->total, 2) }}
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="clearfix mt-3">
        <h2>Invoice must be paid within 30 days</h2>
    </div>
@endsection
