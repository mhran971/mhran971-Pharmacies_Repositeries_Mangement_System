<?php

namespace App\Services\GeneralServices;


use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Log;

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
        try {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification(['title' => $title, 'body' => $body])
                ->withData($data);
            $this->messaging->send($message);
            Log::info("Firebase notification sent successfully to token: {$token}");
        } catch (\Exception $e) {
            Log::error("Failed to send Firebase notification: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send low stock notification
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function sendLowStockNotification($stock): void
    {
        if ($stock->quantity < 5) {
            $this->send(
                'cmpQaOwTR9-_ssTSsK7vG5:APA91bEsPUfxur90meuOHXzLNNtVuVljPtVC_YH6l3L1PHcTPGmsUxAkoPGS_Y9KwZz6csNLIldTUGUdiwELZYGLFRtD1Lm8OageQb8aqDz9gCDP_GcjLKk',
                "{$stock->pharmacy->owner->name} be attention to your Stock",
                "You don’t have {$stock->medicine->trade_name} in your stock, just [{$stock->quantity}] left!"
            );
        }
    }

}
