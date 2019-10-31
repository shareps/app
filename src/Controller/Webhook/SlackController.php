<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Controller\Webhook;

use App\Slack\SlashCommand\CommandHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/webhook/slack", name="webhook_slack")
 */
class SlackController extends AbstractController
{
    /**
     * @Route("/command", name="_command", methods={"post"})
     */
    public function commandAction(
        Request $request,
        CommandHelper $commandHelper
    ): JsonResponse {
        $data = $request->request->all();
        $responseData = $commandHelper->handleWebhook($data);

        return new JsonResponse($responseData, Response::HTTP_OK);
    }

    /**
     * @Route("/interaction", name="_interaction", methods={"post"})
     */
    public function interactionAction(
        Request $request,
        CommandHelper $commandHelper
    ): JsonResponse {
        $data = $request->request->all();
        $responseData = $commandHelper->handleWebhook($data);

        return new JsonResponse($responseData, Response::HTTP_OK);
    }
}
