<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class Lang {
    public static function lang( $items ) {

        if ( Session::get( 'locale' ) == 'ar' ) {
            foreach ( $items as $item ) {
                $item[ 'name' ] = $item[ 'ar_name' ] ? $item[ 'ar_name' ] : $item[ 'name' ];
                $item[ 'slug' ] = $item[ 'ar_slug' ] ? $item[ 'ar_slug' ] : $item[ 'slug' ];
                $item[ 'description' ] = $item[ 'ar_description' ] ? $item[ 'ar_description' ] : $item[ 'description' ];

                unset(
                    $item[ 'ar_name' ],
                    $item[ 'ar_slug' ],
                    $item[ 'ar_description' ],
                    $item[ 'fr_name' ],
                    $item[ 'fr_slug' ],
                    $item[ 'fr_description' ],
                );
            }

        } elseif ( Session::get( 'locale' ) == 'fr' ) {
            foreach ( $items as $item ) {
                $item[ 'name' ] = $item[ 'fr_name' ] ? $item[ 'fr_name' ] : $item[ 'name' ];
                $item[ 'slug' ] = $item[ 'fr_slug' ] ? $item[ 'fr_slug' ] : $item[ 'slug' ];
                $item[ 'description' ] = $item[ 'fr_description' ] ? $item[ 'fr_description' ] : $item[ 'description' ];

                unset(
                    $item[ 'fr_name' ],
                    $item[ 'fr_slug' ],
                    $item[ 'fr_description' ],
                    $item[ 'ar_name' ],
                    $item[ 'ar_slug' ],
                    $item[ 'ar_description' ],
                );
            }
        }

        return $items;
    }
}
