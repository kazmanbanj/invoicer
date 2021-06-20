@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form action="{{ route('invoices.index') }}" method="GET">
                        <input type="search" name="query" placeholder="Enter a keyword here..." onfocus="this.value=''" value="{{ request('query') }}" />
                        <input type="submit" class="btn btn-sm btn-info" value="Search" />
                    </form>
                    <br>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <tr>
                            <th>Invoice Date</th>
                            <th>Invoice Number</th>
                            <th>Customer</th>
                            <th>Total Amount(&#8358;)</th>
                            <th></th>
                        </tr>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->customer->name }}</td>
                                <td>{{ number_format($invoice->total_amount, 2) }}</td>
                                <td>
                                <div class="d-flex">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-primary btn-sm">View Invoice</a>
                                    <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-warning ml-3 btn-sm">Download PDF</a>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
