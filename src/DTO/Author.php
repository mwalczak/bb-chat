<?php

declare(strict_types=1);


namespace App\DTO;

class Author implements Linkable
{
    public function __construct(private string $name, private Link $link, private Link $avatar)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['display_name'],
            Link::fromBody($body['links']['html']),
            Link::fromBody($body['links']['avatar'])
        );
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getLink(): string
    {
        return (string)$this->link;
    }
}
