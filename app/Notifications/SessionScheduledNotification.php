<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SessionScheduledNotification extends Notification
{
    use Queueable;

    protected $session;
    protected $theme;

    public function __construct($session, $theme)
    {
        $this->session = $session;
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
            'session_id' => $this->session->id,
            'title' => 'Nouvelle session planifiée',
            'message' => "Une nouvelle session a été ajoutée pour le thème \"{$this->theme->title}\" le {$this->session->date}.",
            'action_url' => "/formateur/themes/{$this->theme->id}",
            'type' => 'session'
        ];
    }
}
