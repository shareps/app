<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotOverlappedDates extends Constraint
{
    public const INVALID_FROM_DATE = 'FromDate {{ fromDate }} is invalid';
    public const INVALID_TO_DATE = 'ToDate {{ toDate }} is invalid';
    public const INVALID_ORDER = 'FromDate {{ fromDate }} should be before ToDate {{ toDate }}';
    public const INVALID_PERIOD_OVERLAPPED = 'Period {{ fromDate }} - {{ toDate }} overlapped by [{{ periods }}]';
    public $message = '{{ message }}';
    /** @var string|null */
    public $fromDateProperty;
    /** @var string|null */
    public $toDateProperty;
    /** @var string|null */
    public $fromDateMethod;
    /** @var string|null */
    public $toDateMethod;

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
