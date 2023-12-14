<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $fillable = [ 'store_id', 'user_id', 'payment_status', 'payment_method', 'status' ];

    public function delivery() {
        return $this->hasOne(Delivery::class);
    }
    public function store() {
        return $this->belongsTo( Store::class );
    }

    public function user() {
        return $this->belongsTo( User::class )
        ->withDefault( [
            'name' => 'Guest Customer',
        ] );
    }

    public function products() {
        return $this->belongsToMany( Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id' )
        ->using(OrderItems::class)
        ->withPivot( [
            'product_name', 'price', 'quantity', 'options',
        ] );
    }

    public function items() {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    public function addresses() {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress() {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id' )
        ->where('type', 'billing');
    }

    public function shippingAddress() {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id' )
        ->where('type', 'shipping');
    }

    protected static function booted() {
        static::creating(function(Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }

    protected static function getNextOrderNumber() {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');

        return $number ? ++$number : $year . '0001';
    }

}
