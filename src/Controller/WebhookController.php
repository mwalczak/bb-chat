<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\BitbucketParser;
use App\Service\HetrixParser;
use App\Service\WebhookSender;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{
    #[Route('/bitbucket/{key}', name: 'bitbucket')]
    public function bitbucket(string $key, Request $request, LoggerInterface $logger, WebhookSender $webhookSender): Response
    {
        try {
            $webhookBody = $request->toArray();
            $logger->info($request->getContent());
            $webhook = BitbucketParser::parse($webhookBody);
            $webhook->title = (string) $request->headers->get('X-Event-Key', 'Unknown event');
            $webhook->date = (string) $request->headers->get('X-Event-Time', '');
            $webhookSender->send($key, $webhook);
        } catch (\Exception $ex) {
            return new Response($ex->getMessage(), 400);
        }

        return new Response('ok');
    }

    #[Route('/hetrix/{key}', name: 'hetrix')]
    public function hetrix(string $key, Request $request, LoggerInterface $logger, WebhookSender $webhookSender): Response
    {
        try {
            $webhookBody = $request->toArray();
            $logger->info($request->getContent());
            $webhook = HetrixParser::parse($webhookBody);
            $webhookSender->send($key, $webhook);
        } catch (\Exception $ex) {
            return new Response($ex->getMessage(), 400);
        }

        return new Response('ok');
    }
}
