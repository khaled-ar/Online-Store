@extends('layouts.admin')
@section('title', 'New Admin')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">New Admin</li>
@endsection
@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />

    @if (!$users->count())
        <div class="alert alert-info">
            <h3 class="text-center">No Users To Set It Admin Now.</h3>
        </div>
    @else
        <table class="table" style="margin-left: 250px; width:auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="mb-2">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><a href="{{ route('dashboard.admins.make-admin', $user->id) }}"
                                class="btn btn-sm btn-outline-primary">SET
                                ADMINSTRATOR</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
</div>
