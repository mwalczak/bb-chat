<?php

declare(strict_types=1);


namespace App\Service;

use App\DTO\Author;
use App\DTO\Comment;
use App\DTO\PullRequest;
use App\DTO\Repository;
use App\DTO\Webhook;

class WebhookParser
{
    public static function parse(array $webhookBody): Webhook
    {
        $webhook = new Webhook();
        if (!empty($webhookBody['comment'])) {
            $webhook->comment = Comment::fromBody($webhookBody['comment']);
        }
        if (!empty($webhookBody['repository'])) {
            $webhook->repository = Repository::fromBody($webhookBody['repository']);
        }
        if (!empty($webhookBody['pullrequest'])) {
            $webhook->pullRequest = PullRequest::fromBody($webhookBody['pullrequest']);
        }
        if (!empty($webhookBody['actor'])) {
            $webhook->author = Author::fromBody($webhookBody['actor']);
        }
        return $webhook;
    }
}
