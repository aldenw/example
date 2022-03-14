<?php

namespace App\Domain\Model\Exception;

class DisputeIsLockedException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Dispute is locked!");
    }
}