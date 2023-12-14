@if ($errors->any())
    <div class="alert alert-danger" style="margin-left: 255px">
        <h2>Errors List ..!!</h2>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
<div style="margin-left: 255px">
        <div class="form-group row">
            <div class="col-sm-10">
                <x-form.input
                    class="form-control-lg"
                    type="text"
                    name="name"
                    :value="$category->name"
                    placeholder="Name"
                />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <x-form.input
                    class="form-control-lg"
                    type="text"
                    name="description"
                    :value="$category->description"
                    placeholder="Description"
                />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <label style="color: #5353ab">Parent Category &nbsp;&nbsp;</label>
                <select @class(['custom-select', 'is-invalid' => $errors->has('parent_id')])
                    style="width: auto" name="parent_id">
                    <option value="" selected>Primary Category</option>
                    @foreach ($parents as $parent)
                        <option value="{{$parent->id}}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{$parent->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <label style="color: #5353ab; display: -webkit-box; width: 233px;">Image &nbsp&nbsp
                    <x-form.input type="file" name="img" accept="image/*" />
                </label>
            </div>
        </div>
        @if($category->img)
            <div class="form-group row">
                <div class="col-sm-10">
                    <img src="{{ asset( 'storage/' . $category->img) }}" alt="" height="80" width="200"
                            style="border-radius: 10px;">
                </div>
            </div>
        @endif
        <div class="form-group row">
            <div class="col-sm-10">
                <label style="color: #5353ab; display: inline; width: 233px;">Status : </label>
                <x-form.radio
                    name="status"
                    :checked="$category->status"
                    :options="['active' => 'Active', 'archived' => 'Archived']"
                />
            </div>
        </div>
        <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </div>
</div>
