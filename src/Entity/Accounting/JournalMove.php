<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity\Accounting;

use App\Entity\EntityInterface;
use App\Entity\Parking\Member;
use App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="accounting_journal_moves")
 */
class JournalMove implements EntityInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var int
     * @ORM\Column(name="given_points", type="integer", nullable=false)
     *
     * @Assert\PositiveOrZero()
     */
    private $givenPoints;

    /**
     * @var int
     * @ORM\Column(name="received_points", type="string", length=255, nullable=false)
     *
     * @Assert\PositiveOrZero()
     */
    private $receivedPoints;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="date", type="date_immutable", nullable=false)
     *
     * @Assert\Date()
     */
    private $date;

    //-------------------------------------------------------------------------------------------

    /**
     * @var Member
     * @ORM\ManyToOne(targetEntity="App\Entity\Parking\Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     */
    private $member;

    /**
     * @var Journal
     * @ORM\ManyToOne(targetEntity="App\Entity\Accounting\Journal", inversedBy="journalMoves")
     * @ORM\JoinColumn(name="journal_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     */
    private $journal;

    //-------------------------------------------------------------------------------------------

    public function __construct(
        Journal $journal,
        Member $member,
        \DateTimeImmutable $date,
        int $givenPoints,
        int $receivedPoints
    ) {
        $this->id = ShortUuid::uuid4();
        $this->journal = $journal;
        $this->member = $member;
        $this->date = $date;
        $this->givenPoints = $givenPoints;
        $this->receivedPoints = $receivedPoints;

        if (0 === $givenPoints && 0 === $receivedPoints) {
            throw new \InvalidArgumentException('Given and Received points are 0');
        }

        if (0 !== $givenPoints && 0 !== $receivedPoints) {
            throw new \InvalidArgumentException('Given and Received points are not 0');
        }
    }
}
