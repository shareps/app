<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Controller\Oauth2;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/oauth2/slack", name="oauth2_slack")
 */
class SlackController extends AbstractController
{
    /**
     * @Route("/connect", name="_connect")
     */
    public function connectAction(ClientRegistry $clientRegistry): RedirectResponse
    {
        return $clientRegistry
            ->getClient('slack')
            ->redirect(['identity.basic', 'identity.email']);
    }

    /**
     * @Route("/check", name="_check")
     */
    public function connectCheckAction(): Response
    {
        if (!$this->getUser()) {
            return new JsonResponse(['status' => false, 'message' => 'User not found!'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $this->redirectToRoute('site_page_contact');
    }
}
