<?php
use App\Models\User;
?>
@extends('layouts.admin')
@section('title', 'Trash Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Trashed Users</li>
@endsection

@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />

    <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-primary mb-5" style="margin-left: 250px">
        Dashboard Page
    </a>
    @if ($users->count())

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
                    <th>EMAIL</th>
                    <th>DELETED AT</th>
                    <th colspan="2">CONTROL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->deleted_at }}</td>
                        <td>
                            <form action="{{ route('dashboard.users.restore', $user) }}" method="post">
                                @csrf
                                {{-- Form method spoofing --}}
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-outline-primary">Restore</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('dashboard.users.force-delete', $user->id) }}" method="post">
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
                    <h3 class="text-center">No Users Found</h3>
                </div>
    @endif
    </tbody>
    </table>

    <div style="margin-left: 250px; margin-right:50px">
        {{ $users->withQueryString()->links() }}
    </div>
@endsection

</div>
