@extends('layouts.admin')
@section('title', 'New User')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">New User</li>
@endsection
@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />

    <form action="{{ route('dashboard.users.store') }}" method="post">
        @csrf
        @include('dashboard.users._form')
    </form>
@endsection
</div>
