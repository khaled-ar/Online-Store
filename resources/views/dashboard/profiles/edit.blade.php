@extends('layouts.admin')
@section('title', 'Edit Profile')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection
@section('content')

<x-alert type="success"/>
<x-alert type="info"/>
<x-alert type="danger"/>

<form action="{{ route('dashboard.profile.update') }}" method="post">
    @csrf
    @method('patch')
    <div style="margin-left: 255px">
        <div class="form-group row" style="margin-bottom: 20px">
            <label style="color: #5353ab">First Name &nbsp;</label>
            <div class="col-sm-3">
                <x-form.input
                    class="form-control"
                    type="text"
                    name="fname"
                    :value="$user->profile->fname"
                />
            </div>

            &nbsp;&nbsp;&nbsp;&nbsp;
            <label style="color: #5353ab">Last Name &nbsp;</label>
            <div class="col-sm-3">
                <x-form.input
                    class="form-control"
                    type="text"
                    name="lname"
                    :value="$user->profile->lname"
                />
            </div>

            &nbsp;&nbsp;&nbsp;&nbsp;
            <label style="color: #5353ab">Gender &nbsp;</label>
            <div class="col-sm-2">
                <x-form.radio
                    name="gender"
                    :options="['male' => 'Male', 'female' => 'Female']"
                    :checked="$user->profile->gender"
                />
            </div>
        </div>
        <hr><br>
        <div class="form-group row" style="margin-bottom: 20px">
            <label style="color: #5353ab">Birth Date &nbsp;</label>
            <div class="col-sm-2">
                <x-form.input
                    class="form-control"
                    type="date"
                    name="birth_date"
                    placeholder="Birth Date"
                    :value="$user->profile->birth_date"
                />
            </div>

            &nbsp;&nbsp;&nbsp;&nbsp;
            <label style="color: #5353ab">Street Address &nbsp;</label>
            <div class="col-sm-3">
                <x-form.input
                    class="form-control"
                    type="text"
                    name="street_address"
                    :value="$user->profile->street_address"
                />
            </div>

            &nbsp;&nbsp;&nbsp;&nbsp;
            <label style="color: #5353ab">City &nbsp;</label>
            <div class="col-sm-3">
                <x-form.input
                    class="form-control"
                    type="text"
                    name="city"
                    :value="$user->profile->city"
                />
            </div>

        </div>
        <hr><br>
        <div class="form-group row" style="margin-bottom: 20px">
            <label style="color: #5353ab">State &nbsp;</label>
            <div class="col-sm-3">
                <x-form.input
                    class="form-control"
                    type="text"
                    name="state"
                    :value="$user->profile->state"
                />
            </div>

            &nbsp;&nbsp;&nbsp;&nbsp;
            <label style="color: #5353ab">Postal Code &nbsp;</label>
            <div class="col-sm-2">
                <x-form.input
                    class="form-control"
                    type="text"
                    name="postal_code"
                    :value="$user->profile->postal_code"
                />
            </div>

        </div>
        <hr><br>
        <div class="form-group row">
            <label style="color: #5353ab">Country &nbsp;&nbsp;</label>
            <div class="col-sm-4">
                <x-form.select
                    style="width: auto"
                    name="country"
                    class="form-control form-select"
                    :options="$countries"
                    :selected="$user->profile->country"
                />
            </div>

            &nbsp;&nbsp;&nbsp;&nbsp;
            <label style="color: #5353ab">Locale &nbsp;&nbsp;</label>
            <div class="col-sm-4">
                <x-form.select
                    style="width: auto"
                    name="local"
                    class="form-control form-select"
                    :options="$locales"
                    :selected="$user->profile->local"
                />
            </div>
        </div>
        <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </div>
    </div>

</form>
@endsection
