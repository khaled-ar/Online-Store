@extends('layouts.admin')
@section('title', 'Import Product')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Import Product</li>
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger" style="margin-left: 255px">
            <h2>Errors List ..!!</h2>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />

    <div style="margin-left: 255px">
        <form action="{{ route('dashboard.products.import') }}" method="post">
            @csrf
            <div class="form-group row">
                <div class="col-sm-4">
                    <label style="color: #5353ab; display: inline; width: 233px;">Number Of Products : </label>
                    <x-form.input type="number" name="count" min="1" max="200000" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Start Import</button>
                </div>
            </div>
        </form>
    </div>
@endsection
