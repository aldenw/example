<?php

namespace App\Domain\Command;

use App\Domain\Event\JsonSerializableTrait;
use JsonSerializable;

class AddDisputeResponseCommand implements JsonSerializable
{
    use JsonSerializableTrait;

    private string $caseNumber;
    private string $message;

    public function __construct(string $caseNumber, string $message)
    {
        $this->caseNumber = $caseNumber;
        $this->message = $message;
    }

    public function getCaseNumber(): string
    {
        return $this->caseNumber;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}