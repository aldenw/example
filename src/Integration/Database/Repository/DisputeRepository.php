<?php

namespace App\Integration\Database\Repository;

use App\Domain\Model\Dispute;
use App\Domain\Repository\DisputeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\TransactionRequiredException;
use Doctrine\Persistence\ManagerRegistry;

class DisputeRepository extends ServiceEntityRepository implements DisputeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dispute::class);
    }

    public function add(Dispute $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws TransactionRequiredException
     */
    public function findByCaseNumber(string $caseNumber, $lockMode = null, $lockVersion = null): ?Dispute
    {
        $query = $this->createQueryBuilder('d')
            ->where('d.caseNumber = :caseNumber')
            ->setParameter('caseNumber', $caseNumber)
            ->getQuery()
            ->setLockMode($lockMode);

        $results = $query->getResult();

        return empty($results) ? null : $results[0];
    }
}