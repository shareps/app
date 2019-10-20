<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Validator\Constraints;

use App\Entity\EntityInterface;
use App\Enum\Functional\ApplicationEnum;
use App\Repository\Functional\NotOverlappedDatesRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class NotOverlappedDatesValidator extends ConstraintValidator
{
    /**
     * @var NotOverlappedDatesRepository
     */
    private $repository;

    public function __construct(NotOverlappedDatesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param EntityInterface               $entity
     * @param NotOverlappedDates|Constraint $constraint
     */
    public function validate($entity, Constraint $constraint): void
    {
        $this->assertInstances($entity, $constraint);
        $this->assertConstraintProperties($entity, $constraint);
        $this->assertDatesInstanceOf($entity, $constraint);

        if (false === $this->validateDatesNotEmpty($entity, $constraint)) {
            return;
        }

        if (false === $this->validateDatesOrder($entity, $constraint)) {
            return;
        }

        $overlappedEntities = $this->repository->getOverlappedEntities(
            \get_class($entity),
            $constraint->fromDateProperty,
            $constraint->toDateProperty,
            $this->getFromDate($entity, $constraint),
            $this->getToDate($entity, $constraint)
        );

        if (1 === \count($overlappedEntities) && $overlappedEntities[0]->getId() === $entity->getId()) {
            return;
        }

        if (\count($overlappedEntities) > 0) {
            $periodsString = '';
            foreach ($overlappedEntities as $overlappedEntity) {
                $periodsString .= sprintf(
                    '%s - %s,',
                    $this->getFromDateString($overlappedEntity, $constraint),
                    $this->getToDateString($overlappedEntity, $constraint)
                );
            }
            $this->context->buildViolation($constraint::INVALID_PERIOD_OVERLAPPED)
                ->setParameter('{{ fromDate }}', $this->getFromDateString($entity, $constraint))
                ->setParameter('{{ toDate }}', $this->getToDateString($entity, $constraint))
                ->setParameter('{{ periods }}', $periodsString)
                ->atPath($constraint->toDateProperty)
                ->addViolation();
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    private function assertInstances($entity, Constraint $constraint): void
    {
        if (!$constraint instanceof NotOverlappedDates) {
            throw new UnexpectedTypeException($constraint, NotOverlappedDates::class);
        }
        if (!$entity instanceof EntityInterface) {
            throw new UnexpectedValueException($entity, EntityInterface::class);
        }
    }

    private function assertConstraintProperties(EntityInterface $entity, NotOverlappedDates $constraint): void
    {
        if (!method_exists($entity, $constraint->fromDateMethod)) {
            throw new InvalidArgumentException(
                sprintf('Method \'%s\' not exist \'%s\'', $constraint->fromDateMethod, \get_class($entity))
            );
        }
        if (!\is_callable([$entity, $constraint->fromDateMethod])) {
            throw new InvalidArgumentException(
                sprintf('Method \'%s\' not public \'%s\'', $constraint->fromDateMethod, \get_class($entity))
            );
        }
        if (!property_exists($entity, $constraint->fromDateProperty)) {
            throw new InvalidArgumentException(
                sprintf('Property \'%s\' not exist \'%s\'', $constraint->fromDateProperty, \get_class($entity))
            );
        }

        if (!method_exists($entity, $constraint->toDateMethod)) {
            throw new InvalidArgumentException(
                sprintf('Method \'%s\' not exist in \'%s\'', $constraint->toDateMethod, \get_class($entity))
            );
        }
        if (!\is_callable([$entity, $constraint->toDateMethod])) {
            throw new InvalidArgumentException(
                sprintf('Method \'%s\' not public \'%s\'', $constraint->toDateMethod, \get_class($entity))
            );
        }
        if (!property_exists($entity, $constraint->toDateProperty)) {
            throw new InvalidArgumentException(
                sprintf('Property \'%s\' not exist \'%s\'', $constraint->toDateProperty, \get_class($entity))
            );
        }
    }

    private function assertDatesInstanceOf(EntityInterface $entity, NotOverlappedDates $constraint): void
    {
        $fromDate = $entity->{$constraint->fromDateMethod}();
        if (null !== $fromDate && !$fromDate instanceof \DateTimeInterface) {
            throw new UnexpectedValueException($fromDate, \DateTimeInterface::class);
        }
        $toDate = $entity->{$constraint->toDateMethod}();
        if (null !== $toDate && !$toDate instanceof \DateTimeInterface) {
            throw new UnexpectedValueException($toDate, \DateTimeInterface::class);
        }
    }

    private function validateDatesNotEmpty(EntityInterface $entity, NotOverlappedDates $constraint): bool
    {
        $result = true;
        if (!$this->getFromDate($entity, $constraint) instanceof \DateTimeInterface) {
            $this->context->buildViolation($constraint::INVALID_FROM_DATE)
                ->setParameter('{{ fromDate }}', 'N/A')
                ->atPath($constraint->fromDateProperty)
                ->addViolation();
            $result = false;
        }
        if (!$this->getToDate($entity, $constraint) instanceof \DateTimeInterface) {
            $this->context->buildViolation($constraint::INVALID_TO_DATE)
                ->setParameter('{{ toDate }}', 'N/A')
                ->atPath($constraint->toDateProperty)
                ->addViolation();
            $result = false;
        }

        return $result;
    }

    private function validateDatesOrder(EntityInterface $entity, NotOverlappedDates $constraint): bool
    {
        $fromDateString = $this->getFromDateString($entity, $constraint);
        $toDateString = $this->getToDateString($entity, $constraint);

        if ($fromDateString >= $toDateString) {
            $this->context->buildViolation($constraint::INVALID_ORDER)
                ->setParameter('{{ fromDate }}', $fromDateString)
                ->setParameter('{{ toDate }}', $toDateString)
                ->atPath($constraint->toDateProperty)
                ->addViolation();

            return false;
        }

        return true;
    }

    private function getFromDate(EntityInterface $entity, NotOverlappedDates $constraint): \DateTimeInterface
    {
        return $entity->{$constraint->fromDateMethod}();
    }

    private function getToDate(EntityInterface $entity, NotOverlappedDates $constraint): \DateTimeInterface
    {
        return $entity->{$constraint->toDateMethod}();
    }

    private function getFromDateString(EntityInterface $entity, NotOverlappedDates $constraint): string
    {
        return $this->getFromDate($entity, $constraint)->format(ApplicationEnum::DATE_FORMAT);
    }

    private function getToDateString(EntityInterface $entity, NotOverlappedDates $constraint): string
    {
        return $this->getToDate($entity, $constraint)->format(ApplicationEnum::DATE_FORMAT);
    }
}
