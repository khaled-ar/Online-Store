@extends('layouts.admin')
@section('title', 'New Product')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">New Product</li>
@endsection
@section('content')

<x-alert type="success"/>
<x-alert type="info"/>
<x-alert type="danger"/>

<form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
   @include('dashboard.products._form')
  </form>
@endsection
</div>
