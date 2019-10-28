<?php

/** @noinspection DuplicatedCode */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Security\GuardAuthenticator;

use AdamPaterson\OAuth2\Client\Provider\SlackResourceOwner;
use App\Entity\Access\SlackIdentity;
use App\Entity\Access\User;
use App\Entity\Parking\Member;
use App\Enum\Functional\RoleEnum;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\SlackClient;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SlackAuthenticator extends SocialAuthenticator
{
    /**
     * @var ClientRegistry
     */
    protected $clientRegistry;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var Router
     */
    protected $router;

    public function __construct(
        ClientRegistry $clientRegistry,
        EntityManagerInterface $entityManager,
        RouterInterface $router
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    /**
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     */
    public function start(
        Request $request,
        AuthenticationException $authException = null
    ): Response {
        return new Response('No authorized!', 403);
    }

    public function supports(Request $request): bool
    {
        return 'oauth2_slack_check' === $request->attributes->get('_route') && $request->isMethod('GET');
    }

    public function getCredentials(Request $request): AccessToken
    {
        return $this->fetchAccessToken($this->getSlackClient());
    }

    /**
     * @param AccessToken $credentials
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?User
    {
        /** @var SlackResourceOwner $slackUser */
        $slackUser = $this->getSlackClient()->fetchUserFromToken($credentials);

        /** @var User $user */
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $slackUser->getEmail()]);

        if (!$user) {
            return null;
        }

        $slackIdentity = $user->getSlackIdentity();
        if (!$slackIdentity) {
            $slackIdentity = new SlackIdentity($user, (string) $slackUser->getId(), (string) $slackUser->getEmail());
        }
        $slackIdentity->setTeamId((string) $slackUser->toArray()['team_id']);
        $slackIdentity->setName((string) $slackUser->toArray()['name']);
        $slackIdentity->setIsDeleted((bool) $slackUser->toArray()['deleted']);
        $slackIdentity->setColor((string) $slackUser->toArray()['color']);
        $slackIdentity->setRealName((string) $slackUser->toArray()['real_name']);
        $slackIdentity->setTz((string) $slackUser->toArray()['tz']);
        $slackIdentity->setTzLabel((string) $slackUser->toArray()['tz_label']);
        $slackIdentity->setTzOffset((int) $slackUser->toArray()['tz_offset']);
        $slackIdentity->setIsAdmin((bool) $slackUser->toArray()['is_admin']);
        $slackIdentity->setIsBot((bool) $slackUser->toArray()['is_bot']);
        $slackIdentity->setUpdated((int) $slackUser->toArray()['updated']);
        $slackIdentity->setIsAppUser((bool) $slackUser->toArray()['is_app_user']);

        $member = $user->getMember();
        if (!$member) {
            $member = new Member($slackIdentity->getName(), RoleEnum::MEMBER(), $user);
        }
        $member->setName($slackIdentity->getName());

        $this->entityManager->persist($slackIdentity);
        $this->entityManager->persist($member);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ): JsonResponse {
        return new JsonResponse(
            [
                'message' => strtr(
                    $exception->getMessageKey(),
                    $exception->getMessageData()
                ),
            ],
            JsonResponse::HTTP_FORBIDDEN
        );
    }

    /**
     * @param string $providerKey The provider (i.e. firewall) key
     */
    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        $providerKey
    ): ?Response {
        return new RedirectResponse(
            $this->router->generate('site_page_contact'),
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    private function getSlackClient(): SlackClient
    {
        $client = $this->clientRegistry->getClient('slack');
        assert($client instanceof SlackClient);

        return $client;
    }
}
