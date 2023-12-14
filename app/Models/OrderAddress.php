<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Intl\Countries;

class OrderAddress extends Model {
    use HasFactory;

    protected $fillable = [
        'order_id', 'type', 'fname', 'lname', 'email',
        'phone_number', 'street_address',
        'city', 'postal_code', 'state', 'country'
    ];
    public $timestamps = false;

    public function getFullNameAttribute() {
        return strtoupper( $this->fname . ' ' . $this->lname );
    }

    public function getCountryNameAttribute() {
        return Countries::getName( $this->country );
    }

}
