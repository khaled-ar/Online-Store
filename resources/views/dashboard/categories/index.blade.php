@php
    use App\Models\Category;
@endphp

@extends('layouts.admin')
@section('title', 'Categories Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />


    @can('categories.create')
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-outline-primary mb-5" style="margin-left: 250px">
            + New Category
        </a>
    @endcan

    @cannot('categories.create')
        <div style="margin-left: 235px">
        @endcannot
    
        <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-outline-danger mb-5" style="margin-left: 10px">
            Trash
        </a>
    </div>


    @if ($categories->count())

        <div style="margin-left: 250px;">
            <form action="{{ URL::current() }}" method="get" class="d-felx justify-content-between mb-4">
                <x-form.input name="name" class="form-control" placeholder="Name" style="width: 40%; display: inline;" />
                <select name="status" class="mx-2 custom-select" style="width: auto">
                    <option value="">All</option>
                    <option value="active">Active</option>
                    <option value="archived">Archived</option>
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
                    <th>PARENT</th>
                    <th>PRODUCTS</th>
                    <th>STATUS</th>
                    <th>CREATED AT</th>
                    <th colspan="2">CONTROL</th>
                </tr>
            </thead>
            <tbody>
                {{--
                @forelse ($categories as $category)
                    code....
                @empty
                    <center>
                        <div class="alert alert-info" style="width: 500px">
                            <h1 class="text-center">No Categories Found</h1>
                        </div>
                    </center>
                @endforelse
            --}}
                @foreach ($categories as $category)
                    <tr>
                        <td><img src="{{ asset('storage/' . $category->img) }}" alt="" height="50" width="80"
                                style="border-radius: 10px;"></td>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parent_name ?? '-----' }}</td>
                        <td>{{ $category->product_number }}</td>
                        <td>{{ $category->status }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            @can('categories.update')
                                <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                            @endcan
                        </td>
                        <td>
                            @can('categories.delete')
                                <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    {{-- Form method spoofing --}}
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @else
                <div class="alert alert-info" style="margin-left:250px">
                    <h3 class="text-center">No Categories Found</h3>
                </div>
    @endif
    </tbody>
    </table>

    <div style="margin-left: 250px; margin-right:50px">
        {{ $categories->withQueryString()->links() }}
    </div>
@endsection

</div>
