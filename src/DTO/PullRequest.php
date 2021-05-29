<?php

declare(strict_types=1);


namespace App\DTO;

class PullRequest implements Linkable
{
    public function __construct(private string $title, private Link $link)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['title'],
            Link::fromBody($body['links']['html'])
        );
    }

    public function __toString(): string
    {
        return sprintf(
            "Title: %s\n" .
            "Link: %s",
            $this->title,
            $this->link
        );
    }

    public function getLink(): string
    {
        return (string)$this->link;
    }
}
