<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\NotificationService;
use App\Providers\SesProvider;
use App\User;

class SendNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send-notification {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un mensaje de correo al usuario vía SES';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user_id = $this->argument('user_id');

        $user = new User();
        
        if ($user->setData($user_id)) {

            $service = new NotificationService(new SesProvider(app()));

            $response = $service->notify($user, __('Prueba de envío del mensaje vía SES'));

            if ($response) {
                $result = $response['result'];
                if ($result['ok']) {
                    $this->line('ID: ' . $response['id']);
                    $this->line('EMAIL: ' . $response['email']);
                    $this->line('MESSAGE: ' . $response['message']);
                    $this->line('RESULT: ' . $result['message']);
                }
                else {
                    $errors = $result['errors'];
                    $this->line('ERROR:');
                    foreach ($errors as $error) {
                        $this->line('- ' . $error);
                    }
                }
            } else {
                $this->line('ERROR: ' . __('No se recibió respuesta'));
            }
        } else {
            $this->line('ERROR: ' . __('El usuario :var1 no existe', ['var1' => $user_id]));
        }
    }
}
