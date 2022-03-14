<?php

namespace App\Domain\Repository;

use App\Domain\Model\Dispute;

interface DisputeRepositoryInterface
{
    public function add(Dispute $entity, bool $flush = true): void;

    public function find($id, $lockMode = null, $lockVersion = null): ?Dispute;

    public function findOneBy(array $criteria, array $orderBy = null): ?Dispute;

    /**
     * @return Dispute[]
     */
    public function findAll(): array;

    /**
     * @return Dispute[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;
}