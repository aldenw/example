<?php

namespace App\Domain\Model;

use App\Domain\Event\DisputeResponseCreatedEvent;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Integration\Database\Repository\DisputeResponseRepository")
 * @ORM\Table(name="dispute_responses")
 */
class DisputeResponse extends AggregateRoot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Dispute
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Dispute")
     */
    private $dispute;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $message;

    public function __construct(Dispute $dispute, string $response)
    {
        $this->dispute = $dispute;
        $this->message = $response;

        $this->raise(new DisputeResponseCreatedEvent());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDispute(): Dispute
    {
        return $this->dispute;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
