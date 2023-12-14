<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller {
    public function edit() {
        return view( 'dashboard.profiles.edit', [
            'user' => Auth::user(),
            'countries' => Countries::getNames( 'en' ),
            'locales' => Languages::getNames( 'en' ),
        ] );
    }

    public function update( Request $request ) {
        $request->validate( [
            'fname' => [ 'required', 'string', 'max:255' ],
            'lname' => [ 'required', 'string', 'max:255' ],
            'birth_date' => [ 'nullable', 'date', 'before:now' ],
            'gender' => [ 'in:male,female' ],
            'country' => [ 'required', 'string', 'size:2' ],
        ] );

        $request->user()->profile
        ->fill( $request->all() )
        ->save();

        return Redirect::route( 'dashboard.profile.edit' )
        ->with( 'success', 'Profile Updated Successfully.' );
    }
}
