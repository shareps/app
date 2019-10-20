<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Api\Dto\Parking;

use ApiPlatform\Core\Annotation as OA;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class MemberInputDto
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="250")
     *
     * @Serializer\Groups({"post", "put"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "example"="John Doe"},
     *     }
     * )
     */
    public $name;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"App\Enum\Functional\RoleEnum", "toArray"})
     * @Assert\Length(min="1", max="50")
     *
     * @Serializer\Groups({"post", "put"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "enum"={"ROLE_MEMBER", "ROLE_MANAGER"}, "example"="ROLE_MEMBER"},
     *     }
     * )
     */
    public $role;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @Serializer\Groups({"post", "put"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "example"="example@email.com"},
     *     }
     * )
     */
    public $email;
}
