<?php

namespace App\Domain\Command;

use App\Domain\Event\JsonSerializableTrait;
use JsonSerializable;

class CreateDisputeCommand implements JsonSerializable
{
    use JsonSerializableTrait;

    private string $caseNumber;

    public function __construct(string $caseNumber)
    {
        $this->caseNumber = $caseNumber;
    }

    public function getCaseNumber(): string
    {
        return $this->caseNumber;
    }
}