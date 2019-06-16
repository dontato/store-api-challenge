<?php

namespace App\Notifications;

class ResetPassword extends BaseNotification
{
    /**
     * @inheritdoc
     */
    protected $translations = 'password';

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Url for action button
     * @param  mixed $notifiable
     * @return string
     */
    public function url($notifiable)
    {
        return url('/cuenta/reset/' . $this->token);
    }
}
