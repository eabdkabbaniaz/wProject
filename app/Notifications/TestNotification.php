<?php

namespace App\Notifications;

use App\Models\Order\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class TestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $exam_name;
    protected  $orderDelivery="djkfds";
    public function __construct($exam_name)
    {
        $this->exam_name = $exam_name;
    }

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }


    public function toFcm($notifiable): FcmMessage
    {
          return FcmMessage::create()
        ->setNotification(
            FcmNotification::create()
                ->setTitle($this->exam_name)
                ->setBody('يوجد امتحان')
        )
        ->setData([
            'exam' => $this->exam_name,
        ]);
    }
}
