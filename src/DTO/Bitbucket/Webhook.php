<?php

declare(strict_types=1);


namespace App\DTO\Bitbucket;

use App\DTO\AbstractWebhook;
use App\DTO\Linkable;
use App\DTO\Webhookable;
use ReflectionClass;

class Webhook extends AbstractWebhook implements Webhookable
{
    public Comment $comment;
    public PullRequest $pullRequest;
    public Repository $repository;
    public Author $author;
    public $reviewers;

    public function __toString(): string
    {
        $text = '';
        foreach (get_object_vars($this) as $var) {
            if (is_object($var)) {
                $class = new ReflectionClass($var);
                $text .= sprintf("\n%s\n%s", $class->getShortName(), $var);
            }
        }
        return $text;
    }

    public function toCard(): array
    {
        $widgets = [];
        foreach ($this as $var) {
            if (is_object($var)) {
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
            } elseif (is_array($var)) {
                $section = [
                    'topLabel' => '',
                    'content'  => ''
                ];
                $content = [];
                foreach ($var as $item) {
                    $class = new ReflectionClass($item);
                    $section['topLabel'] = $class->getShortName();
                    if ($class->implementsInterface(Linkable::class)) {
                        /** @var Linkable $item */
                        $content[] = "<a href='" . $item->getLink() . "'>" . (string)$item . "</a>";
                    }
                }
                $section['content'] = implode(', ', $content);
                $widgets[] = [
                    'keyValue' => $section
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
