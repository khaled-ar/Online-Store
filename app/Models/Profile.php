<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id', 'fname', 'lname', 'birth_date', 'gender',
        'street_address', 'city', 'state', 'postal_code',
        'country', 'local',
    ];

    // create relation with user model
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
