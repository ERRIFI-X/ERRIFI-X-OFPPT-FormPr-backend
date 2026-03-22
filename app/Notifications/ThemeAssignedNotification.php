<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ThemeAssignedNotification extends Notification
{
    use Queueable;

    protected $theme;
    protected $cdc;

    public function __construct($theme, $cdc)
    {
        $this->theme = $theme;
        $this->cdc = $cdc;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'theme_id' => $this->theme->id,
            'title' => 'Nouveau thème assigné',
            'message' => "Vous avez été assigné au thème \"{$this->theme->title}\" par {$this->cdc->name}.",
            'action_url' => "/formateur/themes/{$this->theme->id}",
            'type' => 'assignment'
        ];
    }
}
