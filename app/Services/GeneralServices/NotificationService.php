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
        $serviceAccountPath = storage_path('app/learningapp-4736c-e9b4b11b72fc.json');

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
    public function send( //$token,
        $title, $body, $data = []): void
    {
        $token = 'cFCIC9hEQGiqDRXxG-0YX9:APA91bF5rXFV17oxRaOR6T5lrorSypCfHEJWsvAhOGfA78qZEYOWA7oSjLrqu2RX7HilEqoBwdyprUUFESq5RvRzsqjinf4YiC5sUSa7bD4qxLSa28KwWuEfCZnwR50braEi75ExjPQL';
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(['title' => $title, 'body' => $body])
            ->withData($data);
        $this->messaging->send($message);
    }
}
