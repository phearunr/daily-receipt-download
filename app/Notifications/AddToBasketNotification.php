<?php

namespace App\Notifications;

use App\Models\OrderDrop;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddToBasketNotification extends Notification
{
    use Queueable;
    private $order_drop;
    private $user;
    private $method;

    /**
     * Create a new notification instance.
     */
    public function __construct(OrderDrop $order_drop, User $user, $method = null)
    {
        $this->order_drop = $order_drop;
        $this->user = $user;
        $this->method = $method;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user' => $this->user,
            'method' => $this->method,
            'order_drop' => $this->order_drop->order
        ];
    }
}
