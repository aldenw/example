<?php

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Integration\Database\Repository\DisputeResponseRepository")
 * @ORM\Table(name="dispute_responses")
 */
class DisputeResponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var Dispute
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\Model\Dispute", inversedBy="responses")
     */
    private Dispute $dispute;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private string $message;

    public function __construct(Dispute $dispute, string $message)
    {
        $this->dispute = $dispute;
        $this->message = $message;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
