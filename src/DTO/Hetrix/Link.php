<?php

declare(strict_types=1);


namespace App\DTO\Hetrix;

class Link
{
    public function __construct(private string $url)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['report_link'],
        );
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
