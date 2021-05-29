<?php

declare(strict_types=1);


namespace App\DTO;

class PullRequest implements Linkable
{
    public function __construct(private string $title, private Link $link, private string $reason)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['title'],
            Link::fromBody($body['links']['html']),
            $body['reason'] ?? ''
        );
    }

    public function __toString(): string
    {
        $text = sprintf(
            "Title: %s\n" .
            "Link: %s",
            $this->title,
            $this->link
        );
        if (!empty($this->reason)) {
            $text .= sprintf("\nReason: %s", $this->reason);
        }
        return $text;
    }

    public function getLink(): string
    {
        return (string)$this->link;
    }
}
