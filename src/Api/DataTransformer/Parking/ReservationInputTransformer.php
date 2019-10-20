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
use App\Api\Dto\Parking\ReservationInputDto;
use App\Entity\Parking\Reservation;
use App\Enum\Entity\ReservationTypeEnum;
use App\Service\Parking\ReservationService;

class ReservationInputTransformer implements DataTransformerInterface
{
    /** @var ValidatorInterface */
    private $validator;
    /** @var ReservationService */
    private $reservationService;

    public function __construct(ValidatorInterface $validator, ReservationService $reservationService)
    {
        $this->validator = $validator;
        $this->reservationService = $reservationService;
    }

    /**
     * @param ReservationInputDto $data
     */
    public function transform($data, string $to, array $context = []): Reservation
    {
        $this->validator->validate($data);

        if (isset($context[AbstractItemNormalizer::OBJECT_TO_POPULATE])
            && $context[AbstractItemNormalizer::OBJECT_TO_POPULATE] instanceof Reservation) {
            /** @var Reservation $reservation */
            $reservation = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
            $reservation = $this->reservationService
                ->updateReservation($reservation, $data->places, new ReservationTypeEnum($data->type));
        } else {
            $reservation = $this->reservationService
                ->createReservation($data->member, $data->date, $data->places, new ReservationTypeEnum($data->type));
        }

        return $reservation;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Reservation) {
            return false;
        }

        return Reservation::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
