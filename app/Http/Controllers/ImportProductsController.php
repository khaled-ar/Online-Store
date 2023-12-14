<?php

namespace App\Http\Controllers;

use App\Jobs\ImportProducts;
use Illuminate\Http\Request;

class ImportProductsController extends Controller {
    public function create() {
        return view( 'dashboard.products.import' );
    }

    public function store( Request $request ) {
        $request->validate( [
            'count' => [ 'required', 'int', 'min:1', 'max:200000' ],
        ] );

        $job = new ImportProducts( $request->post( 'count' ) );
        $job->dispatch()->onQueue( 'import' )->delay( now()->addSeconds( 5 ) );

        return redirect()->route( 'dashboard.products.index' )
        ->with( 'success', 'Import Is Runing...' );
    }
}
