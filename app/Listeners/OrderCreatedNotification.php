<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification as NotificationsOrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class OrderCreatedNotification {
    /**
    * Create the event listener.
    */

    public function __construct() {
        //
    }

    /**
    * Handle the event.
    */

    public function handle( OrderCreated $event ): void {
        $order = $event->order;

        // if we want to send mail to single user ( owner of the store )
        // $user = User::where( 'store_id', $order->store_id )->first();
        // $user->notify( new OrderCreatedNotification( $order ) );

        // if we want to send mail to multiple users ( owners of the store )
        $users = User::where( 'store_id', $order->store_id )->get();
        if ( $users ) {
            Notification::send( $users, new NotificationsOrderCreatedNotification( $order ) );
            // or
            // foreach ( $users as $user ) {
            //     $user->notify( new NotificationsOrderCreatedNotification( $order ) );
            // }
        }
    }
}
