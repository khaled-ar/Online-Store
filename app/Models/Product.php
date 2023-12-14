<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'price', 'compare_price',
        'status', 'img', 'tags', 'store_id', 'category_id', 'slug'
    ];

    protected $hidden = ['img', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['img_url'];
    public function scopeFilter(Builder $builder, array $arr_filters) {

        $builder->when($arr_filters['name'] ?? false, function($builder, $value) {
            $builder->where('products.name', 'LIKE', "%{$value}%");
        });

        $builder->when($arr_filters['status'] ?? false, function($builder, $value) {
            $builder->where('products.status', $value);
        });

        // or
        // if($arr_filters['name'] ?? false) {
        //     $builder->where('name', 'LIKE', "%{$arr_filters['name']}%");
        // }
        // if($arr_filters['status'] ?? false) {
        //     $builder->where('status', $arr_filters['status']);
        // }
    }

    public function scopeActive(Builder $builder) {
        $builder->where('status', 'active');
    }

    public function scopeQuantity(Builder $builder) {
        $builder->where('quantity', '>', 0);
    }

    // create relation with category model
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // create relation with store model
    public function store() {
        return $this->belongsTo(Store::class);
    }

    // create relation with tag model
    public function tags() {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id',
        );
    }

    protected static function booted()
    {
        static::addGlobalScope('store', function(Builder $builder) {
            $user = Auth::user();
            if($user->store_id ?? false) {
                $builder->where('store_id', $user->store_id);
            }
        });

        static::creating(function(Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }

    // define accessors
    public function getImgUrlAttribute() {
        if(!$this->img) {
            return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQDwJQW171kvV8Cwfmj9OR3h0n8yKSHMk7Q_w&usqp=CAU';
        } else {
            if(Str::startsWith($this->img, ['http://', 'https://'])) {
                return $this->img;
            } else {
                return asset('storage/' . $this->img);
            }
        }
    }

    public function getSalePercentAttribute() {
        if($this->compare_price) {
            return -round(($this->price - $this->compare_price) / $this->price, 2) * 100;
        }
    }

    public function scopeApiFilter(Builder $builder, $filters) {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], function($builder, $value) {
            $builder->where('status', $value);
        });

        $builder->when($options['store_id'], function($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tags'] ?? false, function($builder, $value) {

            // method 1 use laravel function
            $builder->whereExists(function($query) use ($value) {
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id', $value);
            });

            // method 2 use Join tables
            // $builder->whereHas('tags', function($builder) use ($value) {
            //     $builder->where('id', $value);
            // });

            // method 3 use sql quere without join tables
            // $builder->selectRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)', [$value]);

            // method 4 use sql query without join tables but it is the best method
            // $builder->selectRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id)'
            //     , [$value]);
        });
    }
}

