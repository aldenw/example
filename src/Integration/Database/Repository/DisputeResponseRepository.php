<?php

namespace App\Integration\Database\Repository;

use App\Domain\Model\DisputeResponse;
use App\Domain\Repository\DisputeResponseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DisputeResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method DisputeResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method DisputeResponse[]    findAll()
 * @method DisputeResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisputeResponseRepository extends ServiceEntityRepository implements DisputeResponseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DisputeResponse::class);
    }

    public function add(DisputeResponse $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
