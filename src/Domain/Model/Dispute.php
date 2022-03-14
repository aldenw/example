<?php

/** @noinspection NonAsciiCharacters */

namespace App\Domain\Model;

use App\Domain\Event\DisputeCreatedEvent;
use App\Domain\Event\DisputeLockedEvent;
use App\Domain\Event\DisputeUnlockedEvent;
use DateInterval;
use DateTime;
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
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $lockedUntil;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private string $caseNumber;

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
        return isset($this->lockedUntil) && $this->lockedUntil < new DateTime();
    }

    public function lockCase(DateInterval $expireTime = null): void
    {
        $expireTime = $expireTime ?? DateInterval::createFromDateString('1 month');

        $this->lockedUntil = (new DateTime())->add($expireTime);

        $this->raise(new DisputeLockedEvent());
    }

    public function unlockCase(): void
    {
        $this->lockedUntil = null;

        $this->raise(new DisputeUnlockedEvent());
    }
}