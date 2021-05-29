<?php

declare(strict_types=1);


namespace App\Service;

use App\DTO\Webhook;
use Symfony\Component\HttpKernel\KernelInterface;

class WebhookSender
{
    private string $environment;

    public function __construct(KernelInterface $kernel)
    {
        $this->environment = $kernel->getEnvironment();
    }

    public function send(string $key, Webhook $webhook, string $title, string $time): void
    {
        $webhooks = require __DIR__ . '/../../config/packages/' . $this->environment . '/webhooks.php';
        if (empty($webhooks[$key])) {
            throw new \Exception('Unknown key');
        }
        $json = json_encode(['cards' => [
            $webhook->toCard($title, $time)
        ]]);
        $options = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $json
        ]]);

        file_get_contents($webhooks[$key], false, $options);
    }
}
