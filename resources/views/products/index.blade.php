@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Products</div>

                <div class="card-body">
                    <form action="{{ route('products.index') }}" method="GET">
                        <input type="search" name="query" placeholder="Enter a keyword here..." onfocus="this.value=''" value="{{ request('query') }}" />
                        <input type="submit" class="btn btn-sm btn-info" value="Search" />
                    </form>
                    <br>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('products.create') }}" class="btn btn-primary">Add new product</a>

                    <br /><br />

                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Price(&#8358;)</th>
                        </tr>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No products found.</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
