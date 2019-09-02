<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Task;

class UserNotification extends Notification
{
    use Queueable;

    private $obj;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($o)
    {
        //
        $this->obj = $o;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase()
    {
        return [
                    'id' => $this->obj->id,
                    'title' => $this->obj->title,
                    'date' => $this->obj->created_at,
                    'type' => get_class($this->obj)
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
?>