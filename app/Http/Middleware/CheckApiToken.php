<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckApiToken {
    /**
    * Handle an incoming request.
    *
    * @param  \Closure( \Illuminate\Http\Request ): ( \Symfony\Component\HttpFoundation\Response )  $next
    */

    public function handle( Request $request, Closure $next ): Response {
        $token = $request->header( 'x-api-key' );
        if ( $token !== config( 'app.api_token' ) ) {
            return FacadesResponse::json( [
                'massage' => 'Invalid API Key'
            ], 400 );
        }
        return $next( $request );
    }
}
