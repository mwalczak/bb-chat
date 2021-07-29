<?php

declare(strict_types=1);


namespace App\Service;

use App\DTO\Bitbucket\Reviewer;
use App\DTO\Bitbucket\Author;
use App\DTO\Bitbucket\Comment;
use App\DTO\Bitbucket\PullRequest;
use App\DTO\Bitbucket\Repository;
use App\DTO\Bitbucket\Webhook;

class BitbucketParser
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
        if (!empty($webhookBody['pullrequest']['reviewers'])) {
            foreach ($webhookBody['pullrequest']['reviewers'] AS $reviewer)
            $webhook->reviewers[] = Reviewer::fromBody($reviewer);
        }
        return $webhook;
    }
}
