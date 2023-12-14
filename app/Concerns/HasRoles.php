<?php

namespace App\Concerns;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles {

    public function roles(): BelongsToMany {
        /**
        * The roles that belong to the HasRole
        *
        * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
        */

        return $this->morphToMany(Role::class, 'authorizable', 'role_user');

    }

    public function hasAbility( $ability ) {
        return $this->roles()->whereHas('abilities', function($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', 'allow');
        })->exists();
    }
}
