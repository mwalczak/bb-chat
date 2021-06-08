<?php


namespace App\DTO;


interface Webhookable
{
    public function __toString(): string;

    public function toCard(): array;
}