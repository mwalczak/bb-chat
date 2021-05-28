<?php

declare(strict_types=1);


namespace App\DTO;

class Comment implements Linkable
{
    public function __construct(private string $text, private Link $link, private Author $author)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['content']['raw'],
            Link::fromBody($body['links']['html']),
            Author::fromBody($body['user'])
        );
    }

    public function __toString(): string
    {
        return sprintf(
            "Text: %s\n" .
            "Author: %s\n",
            $this->text,
            $this->author,
        );
    }

    public function getLink(): string
    {
        return (string)$this->link;
    }
}
