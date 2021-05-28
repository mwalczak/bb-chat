<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\WebhookParser;
use App\Service\WebhookSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{
    #[Route('/webhook/{key}', name: 'webhook')]
    public function index(string $key, Request $request): Response
    {
        try {
            $webhookBody = $request->toArray();
            file_put_contents(__DIR__ . '/../../var/log/dump.log', date('Y-m-d H:i:s') . PHP_EOL . print_r($webhookBody, true) . PHP_EOL . PHP_EOL, FILE_APPEND);
            $webhook = WebhookParser::parse($webhookBody);
            WebhookSender::send($webhook, $key);
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }

        return new Response((string)$webhook);
    }
}
