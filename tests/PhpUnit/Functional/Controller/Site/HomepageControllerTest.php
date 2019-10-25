<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Functional\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomepageControllerTest extends WebTestCase
{
    public function test_requestHomepage_properResponse(): void
    {
        $client = static::createClient([], ['HTTPS' => true]);

        $client->request('GET', '/');
        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertContains('<html lang="en">', $response->getContent());
    }
}
