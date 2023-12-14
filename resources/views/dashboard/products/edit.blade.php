@extends('layouts.admin')
@section('title', 'Edit Product')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Product</li>
@endsection
@section('content')

<x-alert type="success"/>
<x-alert type="info"/>
<x-alert type="danger"/>

<form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    @include('dashboard.products._form')
</form>
@endsection
</div>
