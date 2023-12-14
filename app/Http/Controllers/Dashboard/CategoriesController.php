<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('categories.view');

        // Category::all() return collection object
        $request = request();

        $categories = Category::leftJoin('categories as parent', 'parent.id' , '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parent.name as parent_name',
            ])
            ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as product_number')
            ->Filter($request->query())
            ->latest()
            ->paginate();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('categories.create');
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('categories.create');

        $request->validate(Category::rules());

        // Request Merge
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        // store img
        $data = $request->except('img');
        $data['img'] = $this->uploadImage($request);

        $category = Category::create($data);
        return Redirect::route('dashboard.categories.index')
            ->with('success', 'Category Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('categories.update');

        // $category = Category::find($id);
        // if(!$category) {
        //     abort(404);
        //     // return Redirect::route('dashboard.categories.index');
        // }
        $category = Category::findOrfail($id);
        // $parents = Category::all()->except($id);
        $parents = Category::where('id', '<>', $id)
            ->where(function($query) use($id) {
                $query->whereNull('parent_id')
                ->orWhere('parent_id', '<>', $id);
            })
            ->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('categories.update');

        $request->validate(Category::rules($id));

        $category = Category::find($id);
        $old_img = $category->img;
        // store img
        $data = $request->except('img');
        $new_img = $this->uploadImage($request);
        if($new_img) {
            $data['img'] = $new_img;
        }
        $category->update($data);

        // delete old image
        if($old_img && $new_img) {
            Storage::disk('public')->delete($old_img);
        }
        return Redirect::route('dashboard.categories.index')
            ->with('success', 'Category Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('categories.delete');

        $category = Category::findOrFail($id);
        $category->delete();

        // Category::destroy($id);
        return Redirect::route('dashboard.categories.index')
            ->with('success', 'Category Deleted Successfully.');
    }

    public function trash() {
        $request = request();
        $categories = Category::onlyTrashed()
            ->Filter($request->all())
            ->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id) {
        Gate::authorize('categories.re-store');
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return Redirect::route('dashboard.categories.trash')
            ->with('success', 'Category Restored Successfully.');
    }

    public function forceDelete($id) {
        Gate::authorize('categories.delete');

        Gate::authorize('categories.force-delete');
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if($category->img) {
            Storage::disk('public')->delete($category->img);
        }

        return Redirect::route('dashboard.categories.trash')
            ->with('success', 'Category Deleted Successfully.');
    }

    protected function uploadImage(Request $request) {

        if(!$request->hasFile('img')) {
            return;
        }
        $img = $request->file('img'); // file : return UploadedFile object
        // check if the iploaded file is image
        if(substr($img->getMimeType(), 0, 5) == 'image') {
            return $img->store('uploads', 'public');
        } else {
            Redirect::route('dashboard.categories.index');
        }
    }
}
