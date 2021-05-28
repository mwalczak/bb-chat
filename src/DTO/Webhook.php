<?php

declare(strict_types=1);


namespace App\DTO;

use ReflectionClass;

class Webhook
{
    public Comment $comment;
    public Repository $repository;

    public function __toString(): string
    {
        $text = '';
        foreach (get_object_vars($this) as $var) {
            $class = new ReflectionClass($var);
            $text .= sprintf("\n%s\n%s", $class->getShortName(), $var);
        }
        return $text;
    }

    public function toCard(): array
    {
        $widgets = [];
        foreach (get_object_vars($this) as $var) {
            $class = new ReflectionClass($var);
            $section = [
                'topLabel' => $class->getShortName(),
                'content'  => (string)$var,

            ];
            if ($class->implementsInterface(Linkable::class)) {
                /** @var Linkable $var */
                $section['onClick'] = [
                    'openLink' => [
                        'url' => $var->getLink()
                    ]
                ];
            }
            $widgets[] = [
              'keyValue' => $section
            ];
        }

        return [
            'header' => [
                'title' => $this->getTitle()
            ],
            'sections' => [
                'widgets' => $widgets
            ]
        ];
    }

    private function getTitle(): string
    {
        if ($this->comment) {
            return 'New Comment';
        }
        return 'Unknown event';
    }
}