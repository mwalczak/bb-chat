<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\WebhookParser;
use App\Service\WebhookSender;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{
    #[Route('/webhook/{key}', name: 'webhook')]
    public function index(string $key, Request $request, LoggerInterface $logger): Response
    {
        try {
            $webhookBody = $request->toArray();
            $logger->info($request->getContent());
            $webhook = WebhookParser::parse($webhookBody);
            $title = $request->headers->get('X-Event-Key', 'Unknown event');
            $time = $request->headers->get('X-Event-Time', '');
            WebhookSender::send($key, $webhook, $title, $time, );
        } catch (\Exception $ex) {
            return $this->json($ex->getMessage(), 400);
        }

        return new Response((string)$webhook);
    }
}
