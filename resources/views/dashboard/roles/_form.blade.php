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
            <x-form.input class="form-control-lg" type="text" name="name" :value="$role->name" placeholder="Role Name" />
        </div>
    </div>

    <fieldset>
        <legend>
            {{ __('Abilities') }}
        </legend>

        @php
            $abilities = include app_path('Abilities/abilities.php');
        @endphp
        @foreach ($abilities as $ability_code => $ability_name)
            <div class="row mb-2">
                <div class="col-md-6">
                    {{ $ability_name }}
                </div>
                <div class="col-md-2">
                    <input type="radio" name="abilities[{{ $ability_code }}]" value='allow'
                        @checked(($role_abilities[$ability_code] ?? '') == 'allow')>
                    Allow
                </div>
                <div class="col-md-2">
                    <input type="radio" name="abilities[{{ $ability_code }}]" value='deny'
                        @checked(($role_abilities[$ability_code] ?? '') == 'deny')>
                    Deny
                </div>
            </div>
        @endforeach
    </fieldset>
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
