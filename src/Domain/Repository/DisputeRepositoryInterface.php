<?php

namespace App\Domain\Repository;

use App\Domain\Model\Dispute;

interface DisputeRepositoryInterface
{
    public function add(Dispute $entity, bool $flush = true): void;
    public function findByCaseNumber(string $caseNumber, $lockMode = null, $lockVersion = null);
}