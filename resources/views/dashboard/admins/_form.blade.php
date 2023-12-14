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
            <x-form.input class="form-control-lg" type="text" name="name" :value="$admin->name" placeholder="Name" />
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            <x-form.input class="form-control-lg" type="text" name="email" :value="$admin->email" placeholder="Email" />
        </div>
    </div>
    <h2>Roles</h2>
    @foreach ($roles as $role)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="{{ $role->id }}" name="roles[]"
                id="{{ $role->id }}" @checked(in_array($role->id, $admin_roles))>
            <label class="form-check-label" for="{{ $role->id }}">
                {{ $role->name }}
            </label>
        </div>
    @endforeach
    <div class="form-group row mt-4">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
