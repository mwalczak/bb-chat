<?php

declare(strict_types=1);


namespace App\DTO;

class Link
{
    public function __construct(private string $url)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['href'],
        );
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
