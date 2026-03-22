<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ThemeUpdatedNotification extends Notification
{
    use Queueable;

    protected $theme;

    public function __construct($theme)
    {
        $this->theme = $theme;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'theme_id' => $this->theme->id,
            'title' => 'Mise à jour du thème',
            'message' => "Le thème \"{$this->theme->title}\" a été mis à jour.",
            'action_url' => "/formateur/themes/{$this->theme->id}",
            'type' => 'update'
        ];
    }
}
