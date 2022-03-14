<?php

namespace App\Integration\Database\Repository;

use App\Domain\Model\Dispute;
use App\Domain\Model\DisputeResponse;
use App\Domain\Repository\DisputeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dispute|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dispute|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dispute[]    findAll()
 * @method Dispute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisputeRepository extends ServiceEntityRepository implements DisputeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dispute::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DisputeResponse $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}