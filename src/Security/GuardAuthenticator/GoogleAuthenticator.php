<?php

/** @noinspection DuplicatedCode */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Security\GuardAuthenticator;

use App\Entity\Access\GoogleIdentity;
use App\Entity\Access\User;
use App\Entity\Parking\Member;
use App\Enum\Functional\RoleEnum;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
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

class GoogleAuthenticator extends SocialAuthenticator
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

    public function start(
        Request $request,
        AuthenticationException $authException = null
    ): Response {
        return new Response('No authorized!', 403);
    }

    public function supports(Request $request): bool
    {
        return 'oauth2_google_check' === $request->attributes->get('_route') && $request->isMethod('GET');
    }

    public function getCredentials(Request $request): AccessToken
    {
        return $this->fetchAccessToken($this->getGoogleClient());
    }

    /**
     * @param AccessToken $credentials
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?User
    {
        /** @var GoogleUser $googleUser */
        $googleUser = $this->getGoogleClient()->fetchUserFromToken($credentials);

        /** @var User $user */
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $googleUser->getEmail()]);

        if (!$user) {
            return null;
        }

        $googleIdentity = $user->getGoogleIdentity();
        if (!$googleIdentity) {
            $googleIdentity = new GoogleIdentity($user, $googleUser->getId(), $googleUser->getEmail());
        }
        $googleIdentity->setName($googleUser->getName());
        $googleIdentity->setGivenName($googleUser->getFirstName());
        $googleIdentity->setFamilyName($googleUser->getLastName());
        $googleIdentity->setPicture($googleUser->getAvatar());
        $googleIdentity->setLocale($googleUser->getLocale());

        $member = $user->getMember();
        if (!$member) {
            $member = new Member($googleIdentity->getName(), RoleEnum::MEMBER(), $user);
        }
        $member->setName($googleIdentity->getName());

        $this->entityManager->persist($googleIdentity);
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

    private function getGoogleClient(): GoogleClient
    {
        /** @var GoogleClient $client */
        $client = $this->clientRegistry->getClient('google');

        return $client;
    }
}
