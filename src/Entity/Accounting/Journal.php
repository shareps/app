<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity\Accounting;

use App\Entity\EntityInterface;
use App\Entity\Traits;
use App\Enum\Entity\JournalTypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="accounting_journals")
 */
class Journal implements EntityInterface
{
    use Traits\PropertyIdGeneratedTrait;

    //-------------------------------------------------------------------------------------------

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"App\Enum\Entity\JournalTypeEnum", "toArray"})
     * @Assert\Length(min="1", max="50")
     */
    private $type;

    //-------------------------------------------------------------------------------------------
    /**
     * @var ArrayCollection|JournalMove[]
     * @ORM\OneToMany(targetEntity="App\Entity\Accounting\JournalMove", mappedBy="journal")
     */
    private $journalMoves;

    /**
     * @var Task
     * @ORM\ManyToOne(targetEntity="App\Entity\Accounting\Task", inversedBy="journals")
     * @ORM\JoinColumn(name="journal_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     */
    private $task;

    //-------------------------------------------------------------------------------------------

    public function __construct(Task $task, JournalTypeEnum $type)
    {
        $this->id = ShortUuid::uuid4();
        $this->type = $type->getValue();
        $this->task = $task;
        $this->journalMoves = new ArrayCollection();
    }

    //-------------------------------------------------------------------------------------------

    public function getType(): JournalTypeEnum
    {
        return new JournalTypeEnum($this->type);
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    /**
     * @return JournalMove[]|ArrayCollection
     */
    public function getJournalMoves(): ArrayCollection
    {
        return $this->journalMoves;
    }
}
