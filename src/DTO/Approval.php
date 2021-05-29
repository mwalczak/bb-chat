<?php

declare(strict_types=1);


namespace App\DTO;

class Approval
{
    public function __construct(private Author $author)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            Author::fromBody($body['user'])
        );
    }

    public function __toString(): string
    {
        return sprintf(
            "Author: %s",
            $this->author,
        );
    }
}
