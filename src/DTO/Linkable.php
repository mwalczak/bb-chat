<?php

declare(strict_types=1);


namespace App\DTO;

interface Linkable
{
    public function getLink(): string;
}
