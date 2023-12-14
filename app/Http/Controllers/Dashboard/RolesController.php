<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class RolesController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        $roles = Role::paginate();
        return view( 'dashboard.roles.index', compact( 'roles' ) );
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {

        return view( 'dashboard.roles.create', [
            'role' => new Role(),
        ] );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        $request->validate( [
            'name' => [ 'required', 'string', 'max:255', 'unique:roles,name' ],
            'abilities' => [ 'required', 'array' ],
        ] );

        $role = Role::createWithAbilities( $request );
        return redirect()->route( 'dashboard.roles.index' )
        ->with( 'success', 'Role Created Successfully.' );
    }

    /**
    * Display the specified resource.
    */

    public function show( string $id ) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( Role $role ) {
        $role_abilities = $role->abilities()->pluck( 'type', 'ability' )->toArray();
        return view( 'dashboard.roles.edit', compact( 'role', 'role_abilities' ) );
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request, Role $role ) {
        $request->validate( [
            'name' => [ 'required', 'string', 'max:255', "unique:roles,name,{$role->id}" ],
            'abilities' => [ 'required', 'array' ],
        ] );

        $role->updateWithAbilities( $request );

        return redirect()->route( 'dashboard.roles.index' )
        ->with( 'success', 'Role Updated Successfully.' );
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( Role $role ) {
        $role->delete();
        return redirect()->route( 'dashboard.roles.index' )
        ->with( 'success', 'Role Deleted Successfully.' );
    }

    public function trash() {
        $request = request();
        $roles = Role::onlyTrashed()
        ->Filter( $request->all() )
        ->paginate();
        return view( 'dashboard.roles.trash', compact( 'roles' ) );
    }

    public function restore( Request $request, $id ) {
        Gate::authorize( 'roles.re-store' );
        $role = Role::onlyTrashed()->findOrFail( $id );
        $role->restore();

        return Redirect::route( 'dashboard.roles.trash' )
        ->with( 'success', 'Role Restored Successfully.' );
    }

    public function forceDelete( $id ) {
        Gate::authorize( 'roles.delete' );

        Gate::authorize( 'roles.force-delete' );
        $role = Category::onlyTrashed()->findOrFail( $id );
        $role->forceDelete();

        return Redirect::route( 'dashboard.roles.trash' )
        ->with( 'success', 'Role Deleted Successfully.' );
    }
}
