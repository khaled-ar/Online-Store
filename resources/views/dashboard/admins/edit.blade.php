@extends('layouts.admin')
@section('title', 'Edit Admin')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Admin</li>
@endsection
@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />

    <form action="{{ route('dashboard.admins.update', $admin->id) }}" method="post">
        @csrf
        @method('put')
        @include('dashboard.admins._form')
    </form>
@endsection
</div>
