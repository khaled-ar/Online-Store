@php
    use App\Models\Product;
@endphp

@extends('layouts.admin')
@section('title', 'Trash Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Trashed Products</li>
@endsection

@section('content')

<x-alert type="success"/>
<x-alert type="info"/>
<x-alert type="danger"/>

<a href="{{ route('dashboard.products.index') }}"
    class="btn btn-outline-primary mb-5"
    style="margin-left: 250px"
>
    Products Page
</a>
@if($products->count())

        <div style="margin-left: 250px;">
            <form action="{{ URL::current() }}" method="get" class="d-felx justify-content-between mb-4">
                <x-form.input name="name" class="form-control" placeholder="Name" style="width: 40%; display: inline;"/>
                <select name="status" class="mx-2 custom-select" style="width: auto">
                    <option value="">All</option>
                    <option value="active">Active</option>
                    <option value="archived">Archived</option>
                    <option value="draft">Draft</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary mx-2">Search</button>
            </form>
        </div>
        <table class="table" style="margin-left: 250px; width:auto">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>STATUS</th>
                    <th>DELETED AT</th>
                    <th colspan="2">CONTROL</th>
                </tr>
            </thead>
            <tbody>
            {{--
                @forelse ($products as $product)
                    code....
                @empty
                    <center>
                        <div class="alert alert-info" style="width: 500px">
                            <h1 class="text-center">No Products Found</h1>
                        </div>
                    </center>
                @endforelse
            --}}
            @foreach ($products as $product)
            <tr>
                <td><img src="{{ asset( 'storage/' . $product->img) }}" alt="" height="50" width="80"
                    style="border-radius: 10px;"></td>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->status }}</td>
                <td>{{ $product->deleted_at }}</td>
                <td>
                    <form action="{{ route('dashboard.products.restore', $product->id) }}" method="post">
                        @csrf
                        {{-- Form method spoofing --}}
                        @method('put')
                        <button type="submit" class="btn btn-sm btn-outline-primary">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('dashboard.products.force-delete', $product->id) }}" method="post">
                        @csrf
                        {{-- Form method spoofing --}}
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        @else
            <div class="alert alert-info" style="margin-left:250px">
                <h3 class="text-center">No Products Found</h3>
            </div>
        @endif
            </tbody>
        </table>

    <div style="margin-left: 250px; margin-right:50px">
        {{$products->withQueryString()->links()}}
    </div>
@endsection

</div>


