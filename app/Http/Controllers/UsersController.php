<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        return view( 'dashboard.users.index', [
            'users' => User::where( 'type', 'user' )->paginate(),
        ] );
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        return view( 'dashboard.users.create', [
            'user' => new User(),
        ] );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store( Request $request ) {
        $request->validate( [
            'name' => [ 'required', 'string', 'max:255', 'unique:users,name' ],
            'email' => [ 'required', 'email', 'unique:users,email' ],
            'phone' => [ 'nullable', 'string' ],
            'password' => [ 'required', 'string', 'min:8', 'confirmed' ],
            'password_confirmation' => [ 'required', 'string', 'min:8' ],
        ] );

        $user = $request->all();
        $user[ 'password' ] = Hash::make( $user[ 'password' ] );
        $user = User::create( $user );

        if ( $user ) {
            return redirect()->route( 'dashboard.users.index' )
            ->with( 'success', 'User Added Successfully.' );
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

    public function edit( User $user ) {
        return view( 'dashboard.users.edit', compact( 'user' ) );
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request, User $user ) {
        $request->validate( [
            'name' => [ 'required', 'string', 'max:255', "unique:users,name,{$user->id}" ],
            'email' => [ 'required', 'email', "unique:users,email,{$user->id}" ],
            'phone' => [ 'nullable', 'string' ],
        ] );

        $user->update( $request->all() );

        if ( $user ) {
            return redirect()->route( 'dashboard.users.index' )
            ->with( 'success', 'User Updated Successfully.' );
        }
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( User $user ) {
        $user = $user->delete();
        if ( $user ) {
            return redirect()->route( 'dashboard.users.index' )
            ->with( 'success', 'User Trashed Successfully.' );
        }
    }

    public function trash() {
        $users = User::onlyTrashed()->paginate();
        return view( 'dashboard.users.trash', compact( 'users' ) );
    }

    public function restore( string $id ) {

        $user = User::onlyTrashed()->findOrFail( $id )->restore();
        if ( $user ) {
            return redirect()->route( 'dashboard.users.index' )
            ->with( 'success', 'User Restored Successfully.' );
        }
    }

    public function forceDelete( string $id ) {
        $user = User::onlyTrashed()->findOrFail( $id )->forceDelete();
        if ( $user ) {
            return redirect()->route( 'dashboard.users.index' )
            ->with( 'success', 'User Deleted Successfully.' );
        }
    }

}
