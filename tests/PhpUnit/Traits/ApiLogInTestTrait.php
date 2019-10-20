<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Traits;

use App\Entity\Access\User;
use App\Entity\Parking\Member;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @mixin TestCase
 */
trait ApiLogInTestTrait
{
    protected function apiLogInUser(ContainerInterface $container, KernelBrowser $client, User $user): void
    {
        /** @var Session $session */
        $session = $container->get('session');
        // the firewall context (defaults to the firewall name)
        $firewall = 'main';

        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    protected function assertApiLogInUser(ContainerInterface $container, KernelBrowser $client, User $user): void
    {
        $this->apiLogInUser($container, $client, $user);
        $client->request(
            'GET',
            '/api',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    protected function apiLogInMember(ContainerInterface $container, KernelBrowser $client, Member $member): void
    {
        $this->apiLogInUser($container, $client, $member->getUser());
    }

    protected function assertApiLogInMember(ContainerInterface $container, KernelBrowser $client, Member $member): void
    {
        $this->assertApiLogInUser($container, $client, $member->getUser());
    }
}
