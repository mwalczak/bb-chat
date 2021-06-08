<?php

declare(strict_types=1);


namespace App\DTO\Bitbucket;

use App\DTO\Linkable;

class Comment implements Linkable
{
    public function __construct(private string $text, private Link $link)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['content']['raw'],
            Link::fromBody($body['links']['html'])
        );
    }

    public function __toString(): string
    {
        return sprintf("Text: %s\n", $this->text);
    }

    public function getLink(): string
    {
        return (string)$this->link;
    }
}
