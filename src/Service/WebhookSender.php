<?php

declare(strict_types=1);


namespace App\Service;

use App\DTO\Webhook;

class WebhookSender
{
    public static function send(Webhook $webhook, string $key): void
    {
        $webhooks = require __DIR__ . '/../../config/webhooks.php';
        if (empty($webhooks[$key])) {
            throw new \Exception('Unknown key');
        }
        $json = json_encode(['cards' => [
            $webhook->toCard()
        ]]);
        $options = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $json
        ]]);

        file_get_contents($webhooks[$key], false, $options);
    }
}
