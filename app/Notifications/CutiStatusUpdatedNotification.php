<?php

namespace App\Notifications;

use App\Models\Cuti;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCutiStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected $cuti;

    public function __construct(Cuti $cuti)
    {
        $this->cuti = $cuti;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Status pengajuan cuti Anda telah diubah menjadi ' . $this->cuti->status)
            ->action('Lihat Status', url('/cuti/' . $this->cuti->id))
            ->line('Terima kasih telah menggunakan aplikasi kami.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Status pengajuan cuti Anda telah diubah menjadi ' . $this->cuti->status,
            'cuti_id' => $this->cuti->id,  // Perbaikan pada penamaan kolom id
        ];
    }
}
