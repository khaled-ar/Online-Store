<?php
use App\Models\Category;
?>
@extends('layouts.admin')
@section('title', 'Trash Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Trash Roles</li>
@endsection

@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />

    <a href="{{ route('dashboard.roles.index') }}" class="btn btn-outline-primary mb-5" style="margin-left: 250px">
        Dashboard Page
    </a>
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
                    <th>DELETED AT</th>
                    <th colspan="2">CONTROL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td><img src="{{ asset('storage/' . $role->img) }}" alt="" height="50" width="80"
                                style="border-radius: 10px;"></td>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->status }}</td>
                        <td>{{ $role->deleted_at }}</td>
                        <td>
                            @can('roles.re-store')
                                <form action="{{ route('dashboard.roles.restore', $role->id) }}" method="post">
                                    @csrf
                                    {{-- Form method spoofing --}}
                                    @method('put')
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Restore</button>
                                </form>
                            @endcan
                        </td>
                        <td>
                            @can('roles.delete')
                                <form action="{{ route('dashboard.roles.force-delete', $role->id) }}" method="post">
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
