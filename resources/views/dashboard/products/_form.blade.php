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
            <div class="col-sm-4">
                <label style="color: #5353ab">Name &nbsp;&nbsp;</label>
                <x-form.input
                    class="form-control"
                    type="text"
                    name="name"
                    :value="$product->name"
                />
            </div>

            <div class="col-sm-8">
                <label style="color: #5353ab">Description &nbsp;&nbsp;</label>
                <x-form.input
                    class="form-control"
                    type="text"
                    name="description"
                    :value="$product->description"
                />
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <label style="color: #5353ab">Price &nbsp;&nbsp;</label>
                <x-form.input
                    class="form-control"
                    type="text"
                    name="price"
                    :value="$product->price"
                />
            </div>

            <div class="col-sm-4">
                <label style="color: #5353ab">Compare Price &nbsp;&nbsp;</label>
                <x-form.input
                    class="form-control"
                    type="text"
                    name="compare_price"
                    :value="$product->compare_price"
                />
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                <label style="color: #5353ab">Category &nbsp;&nbsp;</label>
                <select @class(['custom-select', 'is-invalid' => $errors->has('category_id')])
                    name="category_id">
                    @foreach (App\Models\Category::all() as $category)
                        <option value="{{$category->id}}" @selected(old('category_id', $product->category_id) == $category->id)>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-4">
                <label style="color: #5353ab">Store &nbsp;&nbsp;</label>
                <select @class(['custom-select', 'is-invalid' => $errors->has('store_id')])
                    name="store_id">
                    @foreach (App\Models\Store::all() as $store)
                        <option value="{{$store->id}}" @selected(old('store_id', $product->store_id) == $store->id)>{{$store->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-6">
                <label style="color: #5353ab; display: inline; width: 233px;">Tags : &nbsp&nbsp</label>
                <x-form.input
                    class="form-control"
                    type="text"
                    name="tags"
                    :value="$tags"
                />
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <label style="color: #5353ab; display: inline; width: 233px;">Status : </label>
                <x-form.radio
                    name="status"
                    :checked="$product->status"
                    :options="['active' => 'Active', 'archived' => 'Archived', 'draft' => 'Draft']"
                />
            </div>

            <div class="col-sm-4">
                <label style="color: #5353ab; display: -webkit-box; width: 233px;">Image &nbsp&nbsp</label>
                <x-form.input type="file" name="img" accept="image/*" />
            </div>

            @if($product->img)
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <div class="form-group row">
                <div class="col-sm-4">
                    <img src="{{ asset('storage/' . $product->img) }}" alt="" height="90" width="190"
                            style="border-radius: 10px;">
                </div>
            </div>
            @endif
        </div>

        <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </div>
@push('css-files')
    <link href="{{asset('dist/css/tagify.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('js-files')
    <script src="{{asset('dist/js/tagify.js')}}"></script>
    <script src="{{asset('dist/js/tagify.polyfills.min.js')}}"></script>

    <script>
        var inputElm = document.querySelector('[name=tags]'),
        tagify = new Tagify (inputElm);
    </script>
@endpush
</div>

