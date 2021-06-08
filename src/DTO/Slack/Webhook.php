<?php

declare(strict_types=1);


namespace App\DTO\Slack;

use App\DTO\AbstractWebhook;
use App\DTO\Linkable;
use App\DTO\Webhookable;
use ReflectionClass;

class Webhook extends AbstractWebhook implements Webhookable
{
    /** @var Field[] */
    public array $fields = [];
    public Link $link;
    public string $text;

    public function __construct()
    {
        $this->date = date('Y-m-d H:i:s');
    }

    public function __toString(): string
    {
        $text = $this->title . PHP_EOL;
        foreach (get_object_vars($this) as $var) {
            if (is_array($var)) {
                foreach ($var as $value) {
                    $text = $this->parseVar($value, $text) . PHP_EOL;
                }
            } elseif (is_object($var)) {
                $text = $this->parseVar($var, $text);
            }
        }
        return $text;
    }

    private function parseVar($var, $text): string
    {
        return $text . sprintf("%s", $var);
    }

    private function generateSection($var): array
    {
        $class = new ReflectionClass($var);
        $section = [
            'content' => (string)$var,
        ];
        if ($class->implementsInterface(Linkable::class)) {
            /** @var Linkable $var */
            $section['onClick'] = [
                'openLink' => [
                    'url' => $var->getLink()
                ]
            ];
        }
        return $section;
    }

    public function toCard(): array
    {
        $widgets = [['keyValue' => [
            'content' => $this->text,
        ]]];
        foreach (get_object_vars($this) as $var) {
            if (is_array($var)) {
                foreach ($var as $value) {
                    $widgets[] = [
                        'keyValue' => $this->generateSection($value)
                    ];
                }
            } elseif (is_object($var)) {
                $widgets[] = [
                    'keyValue' => $this->generateSection($var)
                ];
            }
        }

        return [
            'header' => [
                'title'    => $this->title,
                'subtitle' => $this->date
            ],
            'sections' => [
                'widgets' => $widgets
            ]
        ];
    }
}
