<?php

namespace App\Services;

use App\Interfaces\MailerProvider;
use App\Providers\SmtpProvider;
use App\Providers\SesProvider;
use App\User;

class NotificationService {

    private $provider = null;    

    public function __construct(MailerProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Notify to user
     * 
     * @param App\User $user
     * @param string message
     */
    public function notify(User $user, $message = '') 
    {
        $userData = [];
        $result = [];
        $errors = [];
        $okMessage = '';
        $ok = true;

        if (!$user) {
            $errors[]  = __('Falta el usuario') . '.';
            $ok = false;
        }
        if (empty($message)) {
            $errors[] = __('El texto del mensaje no puede ser una cadena vacía');
            $ok = false;
        }
        if ($user) {
            $userData = $user->getData();
            if (!$userData['id']) {
                $errors[] = __('Debe especificar el ID del usuario');
                $ok = false;
            } elseif (!is_int($userData['id']) || intval($userData['id']) <= 0) {
                $errors[] = __('El ID del usuario debe ser un número entero >= 0');
                $ok = false;
            }
            if (!$userData['email']) {
                $errors[] = __('Debe especificar el email del usuario');
                $ok = false;
            } elseif (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = __('El email \':var1\' no es una dirección de correo válida', ['var1' => $userData['email']]);
                $ok = false;
            }
        } else {
            $user = new User();
            $userData = $user->getData();
        }

        if ($ok) {
            $sent = $this->provider->send($userData['email'], $message);

            $mailProtocolText = '';
            $providerClass = get_class($this->provider);
            if ($providerClass == SmtpProvider::class) {
                $mailProtocolText = ' vía SMTP';
            } elseif ($providerClass == SesProvider::class) {
                $mailProtocolText = ' vía SES';
            }

            if ($sent) {
                $okMessage = __('Se envió correctamente el mensaje' . $mailProtocolText);
            } else {
                $errors[] = __('Se produjo un error en el envío del mensaje' . $mailProtocolText);
                $ok = false;
            }
        }

        $result['ok'] = $ok;
        if ($ok) {
            $result['message'] = $okMessage;
        } else {
            $result['errors'] = $errors;
        }
        
        return ['id' => $userData['id'], 'email' => $userData['email'], 'message' => $message, 'result' => $result];
    }
}