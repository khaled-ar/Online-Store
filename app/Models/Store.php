<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model {
    use HasFactory, Notifiable;

    // create relation with product model

    public function products() {
        return $this->hasMany( Product::class );
    }
}
