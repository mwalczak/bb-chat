<?php

declare(strict_types=1);


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebhookControllerTest extends WebTestCase
{
    public function testItShouldReturnBadRequestForEmptyBody(): void
    {
        $client = static::createClient();

        $client->request('POST', '/webhook/notfound');

        $this->assertResponseStatusCodeSame(400);
        $this->assertEquals('Request body is empty.', $client->getResponse()->getContent());
    }

    public function testItShouldReturnBadRequestForNotFoundKey(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/webhook/notfound',
            [],
            [],
            [],
            '{"actor":{"display_name":"Author","links":{"html":{"href":"https://example.com/"}, "avatar":{"href":"https//example.com"}}}}'
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertEquals('Unknown key', $client->getResponse()->getContent());
    }

    public function testItShouldReturnResponse(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/webhook/first_key',
            [],
            [],
            [],
            '{"actor":{"display_name":"Author","links":{"html":{"href":"https://example.com/"}, "avatar":{"href":"https//example.com"}}}}'
        );

        $this->assertResponseIsSuccessful();
        $this->assertEquals('ok', $client->getResponse()->getContent());
    }
}
