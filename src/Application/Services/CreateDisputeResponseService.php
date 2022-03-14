<?php

namespace App\Application\Services;

use App\Application\Transaction\EntityManagerInterface;
use App\Domain\Model\DisputeResponse;
use App\Domain\Repository\DisputeRepositoryInterface;
use App\Domain\Repository\DisputeResponseRepositoryInterface;
use Doctrine\DBAL\LockMode;
use Throwable;

class CreateDisputeResponseService
{
    private DisputeRepositoryInterface $disputeRepository;
    private DisputeResponseRepositoryInterface $disputeResponseRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(DisputeRepositoryInterface $disputeRepository, DisputeResponseRepositoryInterface $disputeResponseRepository, EntityManagerInterface $entityManager)
    {
        $this->disputeRepository = $disputeRepository;
        $this->disputeResponseRepository = $disputeResponseRepository;
        $this->entityManager = $entityManager;
    }


    public function createDisputeResponse($disputeId, string $responseMessage)
    {
        $this->entityManager->beginTransaction();
        try {
            $dispute = $this->disputeRepository->find($disputeId, LockMode::PESSIMISTIC_WRITE);
            $this->disputeResponseRepository->add(new DisputeResponse($dispute, $responseMessage));
            $this->entityManager->commit();
        } catch (Throwable $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}