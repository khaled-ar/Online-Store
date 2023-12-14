<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminsController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        $admins = User::where( 'type', 'admin' )->paginate();
        return view( 'dashboard.admins.index', compact( 'admins' ) );
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        $users = USer::where( 'type', 'user' )->paginate();
        return view( 'dashboard.admins.create', [
            'roles' => Role::all(),
            'users' => $users,
        ] );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        $request->validate( [
            'name' => [ 'required', 'string', 'max:255', 'unique:users,name' ],
            'roles' => [ 'required', 'array' ],
            'email' => [ 'required', 'email', 'unique:users,email' ],
        ] );
        $admin = User::create( $request->all() );
        $admin->roles()->attach( $request->roles );

        if ( $admin ) {
            return redirect()->route( 'dashboard.admins.index' )
            ->with( 'success', 'Admin Created Successfully' );
        }
    }

    /**
    * Display the specified resource.
    */

    public function show( string $id ) {

    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( User $admin ) {
        $admin_roles = $admin->roles()->pluck( 'id' )->toArray();
        $roles = Role::all();
        return view( 'dashboard.admins.edit', compact( 'admin', 'roles', 'admin_roles' ) );
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request, User $admin ) {
        $request->validate( [
            'name' => [ 'required', 'string', 'max:255', "unique:users,name,{$admin->id}" ],
            'roles' => [ 'required', 'array' ],
            'email' => [ 'required', 'email', "unique:users,email,{$admin->id}" ],
        ] );
        $admin->update( $request->all() );
        $admin->roles()->sync( $request->roles );

        if ( $admin ) {
            return redirect()->route( 'dashboard.admins.index' )
            ->with( 'success', 'Admin Updated Successfully' );
        }
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( $id ) {
        User::destroy( $id );
        return redirect()->route( 'dashboard.admins.index' )
        ->with( 'success', 'Admin Deleted Successfully' );
    }

    public function makeAdmin( $id ) {
        try {
            DB::beginTransaction();
            $user = User::where( 'id', $id )->update( [ 'type' => 'admin' ] );
            $user = User::where( 'id', $id )->first();
            $user->roles()->sync( [
                'role_id' => Role::where( 'name', 'Adminstrator' )->first()->id,
            ] );

            if ( $user ) {
                DB::commit();
                return redirect()->route( 'dashboard.admins.index' )
                ->with( 'success', 'The user has been modified to admin successfully.' );
            }

        } catch( \Exception $e ) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
