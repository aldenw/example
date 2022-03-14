<?php

namespace App\Domain\Repository;

use App\Domain\Model\DisputeResponse;

/**
 * @method DisputeResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method DisputeResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method DisputeResponse[]    findAll()
 * @method DisputeResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface DisputeResponseRepositoryInterface
{
    public function add(DisputeResponse $entity, bool $flush = true): void;
}