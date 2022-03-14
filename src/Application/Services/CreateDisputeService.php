<?php

namespace App\Application\Services;

use App\Application\Transaction\EntityManagerInterface;
use App\Domain\Model\Dispute;
use App\Domain\Repository\DisputeRepositoryInterface;
use Exception;

class CreateDisputeService
{
    private DisputeRepositoryInterface $disputeRepository;
    private EntityManagerInterface $entityManager;

    public function createDispute(string $caseNumber)
    {
        $dispute = new Dispute($caseNumber);

        $this->entityManager->beginTransaction();

        try {
            $this->disputeRepository->add($dispute);
        } catch (Exception $e) {
        }
    }
}