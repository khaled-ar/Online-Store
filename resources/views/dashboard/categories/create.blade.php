@extends('layouts.admin')
@section('title', 'New Category')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">New Category</li>
@endsection
@section('content')

<x-alert type="success"/>
<x-alert type="info"/>
<x-alert type="danger"/>

<form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
    @csrf
   @include('dashboard.categories._form')
  </form>
@endsection
</div>
