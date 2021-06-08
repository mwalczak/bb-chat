<?php

declare(strict_types=1);


namespace App\DTO\Hetrix;

class Server
{
    public function __construct(private string $name, private string $target, private string $status)
    {
    }

    public static function fromBody(array $body): self
    {
        return new self(
            $body['monitor_name'],
            $body['monitor_target'],
            $body['monitor_status']
        );
    }

    public function __toString(): string
    {
        return sprintf("Name: %s\nTarget: %s\nStatus: %s", $this->name, $this->target, $this->status);
    }
}
