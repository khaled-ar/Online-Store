@php
    use App\Models\Category;
@endphp

@extends('layouts.admin')
@section('title', 'Roles Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />

    @can('roles.create')
        <a href="{{ route('dashboard.roles.create') }}" class="btn btn-outline-primary mb-5" style="margin-left: 250px">
            + New Role
        </a>
    @endcan

    @if ($roles->count())

        <div style="margin-left: 250px;">
            <form action="{{ URL::current() }}" method="get" class="d-felx justify-content-between mb-4">
                <x-form.input name="name" class="form-control" placeholder="Name" style="width: 40%; display: inline;" />
                <button type="submit" class="btn btn-sm btn-primary mx-2">Search</button>
            </form>
        </div>
        <table class="table" style="margin-left: 250px; width:auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>CREATED AT</th>
                    <th colspan="2">CONTROL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td><a href="{{ route('dashboard.roles.show', $role->id) }}">{{ $role->name }}</a></td>
                        <td>{{ $role->created_at }}</td>
                        <td>
                            @can('roles.update')
                                <a href="{{ route('dashboard.roles.edit', $role->id) }}"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                            @endcan
                        </td>
                        <td>
                            @can('roles.delete')
                                <form action="{{ route('dashboard.roles.destroy', $role->id) }}" method="post">
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
                    <h3 class="text-center">No Roles Found</h3>
                </div>
    @endif
    </tbody>
    </table>

    <div style="margin-left: 250px; margin-right:50px">
        {{ $roles->withQueryString()->links() }}
    </div>
@endsection

</div>
