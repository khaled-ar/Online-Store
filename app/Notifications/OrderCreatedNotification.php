<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    protected $order;
    protected $order_number;
    protected $address;
    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->order_number = $this->order->number;
        $this->address = $this->order->billingAddress;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast', ];

        $channels = ['database', ];
        if($notifiable->selected_notifications_method['order_created']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if($notifiable->selected_notifications_method['order_created']['mail'] ?? false) {
            $channels[] = 'mail';
        }
        if($notifiable->selected_notifications_method['order_created']['broadcast'] ?? false) {
            $channels[] = 'broadcast';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject("New Order : {$this->order_number}")
                    //->from()
                    ->greeting("Hello {$notifiable->name}, ")
                    ->line("A New Order #{$this->order_number} Has Been Created By : {$this->address->full_name}
                    From {$this->address->country_name}")
                    ->action('View The Order', url('/dashboard'));
                    //->line('Thank you for using our application!');
    }


    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {

        return [
            'body' => "A New Order #{$this->order_number} Has Been Created By : {$this->address->full_name} From {$this->address->country_name}",
            'icon' => 'fas fa-envelope mr-2',
            'url' => url('/dashboard'),

        ];
    }

/**
     * Get the database representation of the notification.
     */
    public function toBroadcast(object $notifiable)
    {
        return new BroadcastMessage([
            'body' => "A New Order #{$this->order_number} Has Been Created By : {$this->address->full_name} From {$this->address->country_name}",
            'icon' => 'fas fa-envelope mr-2',
            'url' => url('/dashboard'),

        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
