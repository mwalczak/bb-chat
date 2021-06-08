<?php

declare(strict_types=1);


namespace App\DTO;

interface Webhookable
{
    public function __toString(): string;

    public function toCard(): array;
}
