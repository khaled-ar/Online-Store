@extends('layouts.admin')
@section('title', 'New Role')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">New Role</li>
@endsection
@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />

    <form action="{{ route('dashboard.roles.store') }}" method="post">
        @csrf
        @include('dashboard.roles._form')
    </form>
@endsection
</div>
