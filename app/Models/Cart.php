<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $fillable = ['cookie_id', 'user_id', 'product_id', 'quantity', 'options'];

    // events
    protected static function booted() {

        // global scope to set where condition
        static::addGlobalScope('cookie_id', function(Builder $builder) {
            $builder->where('cookie_id', Cart::getCookieId());
        });
        // multible events (with observer)
        static::observe(CartObserver::class);

        // single event (with out observer)
        // static::creating(function(Cart $cart) {
        //     $cart->id = Str::uuid();
        // });
    }

    // create relation with user model
    public function user() {
        return $this->belongsTo(User::class)
            ->withDefault(['name' => 'Anonymous']);
    }

    // create relation with product model
    public function product() {
        return $this->belongsTo(Product::class);
    }

    public static function getCookieId() {
        $cookie_id = Cookie::get('cart_id');
        if(!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue(
                'cart_id',
                $cookie_id,
                3 * (30*24*60),
            );
        }
        return $cookie_id;
    }
}
