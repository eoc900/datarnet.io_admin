<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        return (new MailMessage)
            ->subject('Verificación de Dirección de Correo Electrónico')
            ->greeting('¡Hola!')
            ->line('Por favor, haz clic en el botón de abajo para verificar tu dirección de correo electrónico.')
            ->action('Verificar Dirección de Correo Electrónico', $verificationUrl)
            ->line('Si no creaste una cuenta, no se requiere ninguna otra acción.')
            ->salutation('Saludos, equipo '.env('APP_NAME').'.');
    }
}
