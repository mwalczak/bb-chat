<?php

declare(strict_types=1);


namespace App\DTO\Hetrix;

use App\DTO\Linkable;

class Blacklist implements Linkable
{
    public function __construct(private string $ip, private string $label, private int $before, private int $now, private Link $link)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['monitor'],
            $body['label'],
            intval($body['blacklisted_before']),
            intval($body['blacklisted_now']),
            Link::fromBody($body['links'])
        );
    }

    public function __toString(): string
    {
        return sprintf("IP: %s\nLabel: %s\nBefore: %d\nNow: %d", $this->ip, $this->label, $this->before, $this->now);
    }

    public function getLink(): string
    {
        return (string)$this->link;
    }
}
