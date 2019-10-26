<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\EventSubscriber;

use App\Entity\Access\User;
use App\Entity\System\RequestLog;
use App\Entity\System\RequestLogDetail;
use App\Enum\Entity\RequestLogTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SystemRequestSubscriber implements EventSubscriberInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var TokenStorageInterface TokenStorageInterface */
    private $tokenStorage;
    /** @var RequestLog|null */
    private $requestLog;
    /** @var RequestLogDetail|null */
    private $requestLogDetail;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 0],
            ],
            KernelEvents::RESPONSE => [
                ['onKernelResponse', 0],
            ],
            KernelEvents::EXCEPTION => [
                ['onKernelException', 0],
            ],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ('_wdt' === $request->attributes->get('_route')) {
            return;
        }

        $member = null;
        $token = $this->tokenStorage->getToken();
        if ($token instanceof TokenInterface) {
            /** @var User $user */
            $user = $token->getUser();
            if ($user instanceof User) {
                $user = $this->entityManager->find(User::class, $user->getId());
                $member = $user->getMember();
            }
        }

        $this->requestLog = new RequestLog(
            RequestLogTypeEnum::HTTP(),
            $request->getPathInfo(),
            new \DateTimeImmutable(),
            $member
        );

        $this->requestLogDetail = new RequestLogDetail(
            $this->requestLog,
            $request->getRequestUri(),
            json_encode(
                [
                    'query' => $request->query->all(),
                    'request' => $request->request->all(),
                    'attributes' => $request->attributes->all(),
                    'headers' => $request->headers->all(),
                ],
                JSON_THROW_ON_ERROR
            )
        );

        $this->entityManager->persist($this->requestLog);
        $this->entityManager->persist($this->requestLogDetail);
        $this->entityManager->flush();
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (null === $this->requestLog) {
            return;
        }

        if (!$event->isMasterRequest()) {
            return;
        }

        $this->requestLog->setFinishedAt(new \DateTimeImmutable());
        $this->requestLog->setSuccessful(true);

        $this->entityManager->persist($this->requestLog);
        $this->entityManager->persist($this->requestLogDetail);
        $this->entityManager->flush();
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (null === $this->requestLog) {
            return;
        }

        if (!$event->isMasterRequest()) {
            return;
        }

        $this->requestLog->setSuccessful(false);

        $this->entityManager->persist($this->requestLog);
        $this->entityManager->persist($this->requestLogDetail);
        $this->entityManager->flush();
    }
}
