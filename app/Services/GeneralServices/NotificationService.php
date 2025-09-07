<?php

namespace App\Services\GeneralServices;


use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationService
{

    protected \Kreait\Firebase\Contract\Messaging $messaging;

    public function __construct()
    {
        $serviceAccountPath = storage_path('app/pharmes-app-21a5cbf86c17.json');

        // Initialize the Firebase Factory with the service account
        $factory = (new Factory)->withServiceAccount($serviceAccountPath);

        // Create the Messaging instance
        $this->messaging = $factory->createMessaging();
    }
//    public function index()
//    {
//        return auth()->user()->notifications;
//    }


    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function send($token,
                         $title, $body, $data = []): void
    {
//        $token='fG9hNCPbTdmKyaEnStCuC0:APA91bHXkcYollGGOalt-SGqprEUqbG-SKIPE_bvikzOJ3JH1d4n_2_SGSHvwLUTjJhDOoOlhweTcNmu8Q4umoLTP7woAkWXfSkRsgqM3oIoLzzA58h4Z_8';
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(['title' => $title, 'body' => $body])
            ->withData($data);
        $this->messaging->send($message);
    }

}
