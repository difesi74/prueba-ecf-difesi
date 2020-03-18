<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\NotificationService;
use App\Providers\SmtpProvider;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendNotification($user_id = 0) {

        $response = [];

        $user = new User();
        if ($user->setData($user_id)) {
            $service = new NotificationService(new SmtpProvider(app()));

            $response = $service->notify($user, 'Prueba de envío del mensaje vía SMTP');
        } else {
            $response = ['result' => ['ok' => 'false', 'errors' => [__('El usuario :var1 no existe', ['var1' => $user_id])]]];
        }

        return response()->json($response);
    }
}
