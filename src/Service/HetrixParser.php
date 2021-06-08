<?php

declare(strict_types=1);


namespace App\Service;

use App\DTO\Hetrix\Blacklist;
use App\DTO\Hetrix\Webhook;

class HetrixParser
{
    public static function parse(array $webhookBody): Webhook
    {
        $webhook = new Webhook();
        if(is_array($webhookBody)){
            $webhook->title = 'Hetrix Blacklist Monitor';
            foreach($webhookBody as $blacklistBody){
                $webhook->blacklists[] = Blacklist::fromBody($blacklistBody);
            }
        }

        return $webhook;
    }
}
