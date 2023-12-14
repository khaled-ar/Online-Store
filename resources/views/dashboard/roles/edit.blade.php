@extends('layouts.admin')
@section('title', 'Edit Role')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Role</li>
@endsection
@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />

    <form action="{{ route('dashboard.roles.update', $role->id) }}" method="post">
        @csrf
        @method('put')
        @include('dashboard.roles._form')
    </form>
@endsection
</div>
