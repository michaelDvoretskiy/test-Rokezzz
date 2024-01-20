<?php

namespace App\Repository;

use App\Entity\ViewedWorkApp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ViewedWorkApp>
 *
 * @method ViewedWorkApp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ViewedWorkApp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ViewedWorkApp[]    findAll()
 * @method ViewedWorkApp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViewedWorkAppRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ViewedWorkApp::class);
    }

//    /**
//     * @return ViewedWorkApp[] Returns an array of ViewedWorkApp objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ViewedWorkApp
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
