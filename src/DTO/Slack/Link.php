<?php

declare(strict_types=1);


namespace App\DTO\Slack;

use App\DTO\Linkable;

class Link implements Linkable
{
    public function __construct(private string $url)
    {
    }

    public static function fromBody(string $body): self
    {
        preg_match('/.+<(.*)\|/U', $body, $matches);
        return new self(
            $matches[1],
        );
    }

    public function __toString(): string
    {
        return $this->url;
    }

    public function getLink(): string
    {
        return $this->url;
    }
}
