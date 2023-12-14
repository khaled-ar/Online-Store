@extends('layouts.admin')
@section('title', 'Edit Category')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Category</li>
@endsection
@section('content')

<x-alert type="success"/>
<x-alert type="info"/>
<x-alert type="danger"/>

<form action="{{ route('dashboard.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    @include('dashboard.categories._form')
</form>
@endsection
</div>
