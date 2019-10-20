<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Api\DataTransformer\Parking;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Parking\Member;
use App\Enum\Functional\RoleEnum;
use App\Service\Parking\MemberService;

class MemberInputTransformer implements DataTransformerInterface
{
    /** @var ValidatorInterface */
    private $validator;
    /** @var MemberService */
    private $memberService;

    public function __construct(ValidatorInterface $validator, MemberService $memberService)
    {
        $this->validator = $validator;
        $this->memberService = $memberService;
    }

    public function transform($data, string $to, array $context = []): Member
    {
        $this->validator->validate($data);

        if (isset($context[AbstractItemNormalizer::OBJECT_TO_POPULATE])
            && $context[AbstractItemNormalizer::OBJECT_TO_POPULATE] instanceof Member) {
            /** @var Member $member */
            $member = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
            $member = $this->memberService->updateMember($member, $data->name, new RoleEnum($data->role));
        } else {
            $member = $this->memberService->createMember($data->name, $data->email, new RoleEnum($data->role));
        }

        return $member;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Member) {
            return false;
        }

        return Member::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
