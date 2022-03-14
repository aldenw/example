<?php

namespace App\Domain\Model\Exception;

class DisputeIsLockedException extends \Exception
{
    public function __construct(\DateTime $lockedUntil)
    {
        parent::__construct("Dispute is locked until " . $lockedUntil->format('Y-m-d'));
    }
}