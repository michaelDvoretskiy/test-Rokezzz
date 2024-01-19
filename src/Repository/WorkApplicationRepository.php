<?php

namespace App\Repository;

use App\Entity\WorkApplication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkApplication>
 *
 * @method WorkApplication|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkApplication|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkApplication[]    findAll()
 * @method WorkApplication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkApplication::class);
    }

    public function getAllWithOrder(string $orderField = '', string $orderType = 'asc')
    {
        return $this->findBy([], $orderField ? [$orderField => $orderType] : []);
    }

//    /**
//     * @return WorkApplication[] Returns an array of WorkApplication objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WorkApplication
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
