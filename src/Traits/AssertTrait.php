<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Traits;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait AssertTrait
{
    private function assertIsValidObject(
        ValidatorInterface $validator,
        object $object,
        array $constraints = null,
        array $groups = null
    ): void {
        $violations = $validator->validate($object, $constraints, $groups);
        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }
    }

    private function assertIsGranted(Security $security, string $attribute, object $subject = null): void
    {
        $isGranted = $security->isGranted($attribute, $subject);
        if (false === $isGranted) {
            throw new AccessDeniedException();
        }
    }
}
