@extends('layouts.admin')
@section('title', 'Edit User')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit User</li>
@endsection
@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />

    <form action="{{ route('dashboard.users.update', $user->id) }}" method="post">
        @csrf
        @method('put')
        @include('dashboard.users._form')
    </form>
@endsection
</div>
