<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Controller\Api\Parking;

use App\Entity\Parking\Member;
use App\Service\Parking\MemberService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AvailabilityDeleteAction extends AbstractController
{
    /** @var MemberService */
    private $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function __invoke(Member $data): void
    {
        $this->memberService->deleteMember($data);
    }
}
