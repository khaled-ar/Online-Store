<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetAppLocale {
    /**
    * Handle an incoming request.
    *
    * @param  \Closure( \Illuminate\Http\Request ): ( \Symfony\Component\HttpFoundation\Response )  $next
    */

    public function handle( Request $request, Closure $next ): Response {
        $locale = request( 'locale', Cookie::get( 'locale', config( 'app.locale' ) ) );
        App::setLocale( $locale );
        Cookie::queue( 'locale', $locale, 365 * 24 * 60 );
        Session::put( 'locale', $locale );
        return $next( $request );
    }
}
