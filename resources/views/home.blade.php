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
                            {{-- <th>S/N</th> --}}
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Year month</th>
                        </tr>
                        @foreach ($data as $invoice)
                            @foreach ($invoice->transactions as $key => $amount)
                            <tr>
                                {{-- <td>{{ $key++ }}</td> --}}
                                <td>{{ $invoice->name }}</td>
                                <td>{{ $amount->amount }}</td>
                                <td>{{ $amount->year }}-{{ sprintf('%02d', $amount->month) }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
