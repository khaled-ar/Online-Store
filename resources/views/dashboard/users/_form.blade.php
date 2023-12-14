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
<div style="margin-left: 255px">
    <div class="form-group row">
        <div class="col-sm-10">
            <label>Name : </label>
            <x-form.input class="form-control-lg" type="text" name="name" :value="$user->name" />
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            <label>Email : </label>
            <x-form.input class="form-control-lg" type="text" name="email" :value="$user->email" />
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            <label>Phone : </label>
            <x-form.input class="form-control-lg" type="text" name="phone" :value="$user->phone" />
        </div>
    </div>
    @if (substr(URL::current(), -12) == 'users/create')
        <div class="form-group row">
            <div class="col-sm-10">
                <label>Password : </label>
                <x-form.input class="form-control-lg" type="password" name="password" :value="$user->email" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <label>Confirm Password : </label>
                <x-form.input class="form-control-lg" type="password" name="password_confirmation" value="" />
            </div>
        </div>
    @endif
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
