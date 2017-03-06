<?php

namespace Distilleries\Expendable\Mails;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 27/02/2017
 * Time: 18:01
 */
class ResetPasswordNotification extends ResetPassword
{

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', url('login/reset', $this->token))
            ->line('If you did not request a password reset, no further action is required.');
    }

}