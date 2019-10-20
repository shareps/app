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
use App\Enum\Entity\TaskTypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="accounting_tasks")
 */
class Task implements EntityInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"App\Enum\Entity\TaskTypeEnum", "toArray"})
     * @Assert\Length(min="1", max="50")
     */
    private $type;

    //-------------------------------------------------------------------------------------------
    /**
     * @var ArrayCollection|Journal[]
     * @ORM\OneToMany(targetEntity="App\Entity\Parking\MemberNeed", mappedBy="task")
     */
    private $journals;

    //-------------------------------------------------------------------------------------------

    public function __construct(TaskTypeEnum $type)
    {
        $this->id = ShortUuid::uuid4();
        $this->type = $type->getValue();
        $this->journals = new ArrayCollection();
    }

    //-------------------------------------------------------------------------------------------

    public function getType(): TaskTypeEnum
    {
        return new TaskTypeEnum($this->type);
    }

    /**
     * @return Journal[]|ArrayCollection
     */
    public function getJournals(): ArrayCollection
    {
        return $this->journals;
    }
}
