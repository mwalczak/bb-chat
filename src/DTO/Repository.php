<?php

declare(strict_types=1);


namespace App\DTO;

class Repository implements Linkable
{
    public function __construct(private string $name, private Link $link)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['name'],
            Link::fromBody($body['links']['html'])
        );
    }

    public function __toString(): string
    {
        return sprintf(
            "Name: %s\n" .
            "Link: %s",
            $this->name,
            $this->link
        );
    }

    public function getLink(): string
    {
        return (string)$this->link;
    }
}
