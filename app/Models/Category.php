<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'parent_id', 'description', 'img', 'status', 'slug'
    ];

    // create relation with product model
    public function products() {
        return $this->hasMany(Product::class);
    }

    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function scopeActive(Builder $builder) {
        $builder->where('status', 'active');
    }

    protected static function booted()
    {
    static::addGlobalScope(function (Builder $builder) {
        $builder->where('status', 'active');
    });
}

    // create scope filter
    public function scopeFilter(Builder $builder, array $arr_filters) {

        $builder->when($arr_filters['name'] ?? false, function($builder, $value) {
            $builder->where('categories.name', 'LIKE', "%{$value}%");
        });

        $builder->when($arr_filters['status'] ?? false, function($builder, $value) {
            $builder->where('categories.status', $value);
        });

        // or
        // if($arr_filters['name'] ?? false) {
        //     $builder->where('name', 'LIKE', "%{$arr_filters['name']}%");
        // }
        // if($arr_filters['status'] ?? false) {
        //     $builder->where('status', $arr_filters['status']);
        // }
    }

    public static function rules($id = 0) {
        return [
            'name' => [
                'required',
                'string',
                'min:5',
                'max:255',
                "unique:categories,name,$id",
                // Rule::unique('categories', 'name')->ignore($id)
                'filter:allah,god,bad,...'
            ],
            // 'description' => [
            //     'string',
            // ],
            'parent_id' => [
                'nullable',
                'int',
                'exists:categories,id',
            ],
            'img' => [
                'image',
                'max:1125899906842624',
                'dimensions:max_width=5000,max_height=5000',
            ],
            'status' => [
                'in:active,archived',
            ]
        ];
    }
}
