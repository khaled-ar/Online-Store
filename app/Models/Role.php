<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Role extends Model {
    use HasFactory;

    protected $fillable = [ 'name', 'role_id' ];

    public function abilities() {
        return $this->hasMany(RoleAbility::class);
    }
    public function scopeFilter(Builder $builder, array $arr_filters) {

        $builder->when($arr_filters['name'] ?? false, function($builder, $value) {
            $builder->where('roles.name', 'LIKE', "%{$value}%");
        });
    }
    public static function createWithAbilities( Request $request ) {

        try {
            DB::beginTransaction();
            $role = Role::create( [ 'name' => $request->post( 'name' ) ] );

            foreach ( $request->post( 'abilities' ) as $ability => $value) {
                RoleAbility::Create( [
                    'role_id' => $role->id,
                    'ability' =>  $ability,
                    'type' => $value,
                ] );
            }
            DB::commit();
        } catch( Exception $e ) {
            DB::rollBack();
            echo $e->getMessage();
        }

        return $role;
    }

    public function updateWithAbilities( Request $request ) {

        try {
            DB::beginTransaction();
            $this->update( [
                'name' => $request->post( 'name' ),
            ] );

            foreach ( $request->post( 'abilities' ) as $ability => $value) {
                RoleAbility::updateOrCreate( [
                    'role_id' => $this->id,
                    'ability' => $ability,
                ], [
                    'type' => $value,
                ] );
            }
            DB::commit();
        } catch( Exception $e ) {
            DB::rollBack();
            abort( 1064, $e->getMessage() );
        }

        return $this;
    }
}
