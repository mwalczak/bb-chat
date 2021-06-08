<?php

declare(strict_types=1);


namespace App\Service;

use App\DTO\Slack\Field;
use App\DTO\Slack\Link;
use App\DTO\Slack\Webhook;

class SlackParser
{
    public static function parse(array $webhookBody): Webhook
    {
        $webhook = new Webhook();

        foreach ($webhookBody['attachments'][0]['fields'] as $fieldBody) {
            $webhook->fields[] = Field::fromBody($fieldBody);
        }
        $webhook->link = Link::fromBody($webhookBody['attachments'][0]['fallback']);
        $webhook->text = $webhookBody['attachments'][0]['pretext'];

        return $webhook;
    }
}
