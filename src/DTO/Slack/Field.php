<?php

declare(strict_types=1);


namespace App\DTO\Slack;

class Field
{
    public function __construct(private string $title, private string $value)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['title'],
            $body['value'],
        );
    }

    public function __toString(): string
    {
        return sprintf("%s: %s", $this->title, $this->value);
    }
}
