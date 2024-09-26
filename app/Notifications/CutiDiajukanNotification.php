<?php

namespace App\Notifications;

use App\Models\Cuti;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CutiDiajukanNotification extends Notification
{
    use Queueable;

    protected $cuti;

    /**
     * Create a new notification instance.
     */
    public function __construct(Cuti $cuti)
    {
        $this->cuti = $cuti;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Notifikasi dikirim via email dan disimpan di database
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Ada pengajuan cuti baru dari user ' . $this->cuti->user->name)
                    ->action('Lihat Pengajuan', url('/admin/cuti/' . $this->cuti->id))
                    ->line('Harap segera memeriksa.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Pengajuan cuti dari ' . $this->cuti->user->name,
            'cuti_id' => $this->cuti->CutiID,
        ];
    }
}

