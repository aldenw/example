<?php

namespace App\Domain\Model;

use App\Domain\Event\DisputeCreatedEvent;
use App\Domain\Event\DisputeLockedEvent;
use App\Domain\Event\DisputeResponseAddedEvent;
use App\Domain\Event\DisputeUnlockedEvent;
use App\Domain\Model\Exception\DisputeIsLockedException;
use DateInterval;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Integration\Database\Repository\DisputeRepository")
 * @ORM\Table(name="disputes")
 */
class Dispute extends AggregateRoot
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $lockedUntil;

    /**
     * @var string
     *
     * @ORM\Column(name="case_number", type="string", nullable=false, unique=true)
     */
    private string $caseNumber;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Domain\Model\DisputeResponse",
     *     mappedBy="dispute",
     *     cascade={"all"}
     * )
     */
    private Collection $responses;

    public function __construct(string $caseNumber)
    {
        $this->caseNumber = $caseNumber;

        $this->raise(new DisputeCreatedEvent());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCaseNumber(): string
    {
        return $this->caseNumber;
    }

    public function isLocked(): bool
    {
        return isset($this->lockedUntil) && $this->lockedUntil > new DateTime();
    }

    /**
     * @throws DisputeIsLockedException
     */
    public function addDisputeResponse(string $message)
    {
        // sleep(120);

        if($this->isLocked()) {
            throw new DisputeIsLockedException($this->lockedUntil);
        }

        $this->lockDispute();

        $this->responses->add(new DisputeResponse($this, $message));

        $this->raise(new DisputeResponseAddedEvent());
    }

    public function lockDispute(DateInterval $expireTime = null): void
    {
        $expireTime = $expireTime ?? DateInterval::createFromDateString('1 month');

        $this->lockedUntil = (new DateTime())->add($expireTime);

        $this->raise(new DisputeLockedEvent());
    }

    public function unlockDispute(): void
    {
        $this->lockedUntil = null;

        $this->raise(new DisputeUnlockedEvent());
    }
}