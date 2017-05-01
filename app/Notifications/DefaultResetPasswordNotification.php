<?php

namespace CodeFlix\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class DefaultResetPasswordNotification extends ResetPassword
{

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Solicitação de redefinição de senha')
            ->line('Você está recebendo esse e-mail, porque uma redefinição de senha foi requisitada.')
            ->action('Redefinir Senha', route('password.reset', $this->token))
            ->line('Se você não fez essa requisição, por favor desconsidere.');
    }


}
