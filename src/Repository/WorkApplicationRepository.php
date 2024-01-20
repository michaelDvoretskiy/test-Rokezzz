<?php

namespace App\Repository;

use App\Entity\ViewedWorkApp;
use App\Entity\WorkApplication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\QueryBuilder;
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

    public function getViewedWithOrder(int  $userId, string $orderField = '', string $orderType = 'asc'): array
    {
        $builder = $this->createQueryBuilder('w')
            ->innerJoin(ViewedWorkApp::class, 'v', Join::WITH, 'v.workApp = w.id')
            ->andWhere('v.UserId = :userId')
            ->setParameter('userId', $userId);
        $this->addWorkAppOrder($builder, $orderField, $orderType);
        return $builder->getQuery()->getResult();
    }

    public function getUnviewedWithOrder(int  $userId, string $orderField = '', string $orderType = 'asc'): array
    {

        $em = $this->getEntityManager();
        $sql = "SELECT w.* 
            FROM work_application w left join (select work_app_id from viewed_work_app where user_id = :userId) v 
                on w.id = v.work_app_id
                where v.work_app_id is null
            ";
        if ($orderField) {
            $sqlFieldName = $em->getClassMetadata(WorkApplication::class)->getColumnName($orderField);
            $sql .= "order by $sqlFieldName $orderType";
        }

        $rsm = new ResultSetMappingBuilder($em);
        $rsm->addRootEntityFromClassMetadata(WorkApplication::class, 'w');
        $nativeQuery = $em->createNativeQuery($sql, $rsm)
            ->setParameter('userId', $userId);

        return $nativeQuery->getResult();
    }
    public function getUnviewedWithOrder2(int  $userId, string $orderField = '', string $orderType = 'asc'): array
    {
        $em = $this->getEntityManager();
        $inner = $em->createQueryBuilder()
            ->select('v.workApp')
            ->from('App:ViewedWorkApp', 'v')
            ->where('v.UserId = :userId')
            ->setParameter('userId', $userId);
        var_dump($inner->getQuery()->getSQL());
        return $inner->getQuery()->getResult();

        $outer = $em->createQueryBuilder();
        $outer->select('w')
            ->from('App:ViewedWorkApp', 'w')
            ->leftJoin('(' . $inner->getDQL() . ')', 'v', Join::WITH, 'w.id = v.workApp');
        var_dump($outer->getDQL());
        return $inner->getQuery()->getResult();
    }

    public function getOldWithOrder(string $orderField = '', string $orderType = 'asc'): array
    {
        $builder = $this->createQueryBuilder('w')
            ->andWhere('w.createdAt < :date')
            ->setParameter('date', $this->getStartDate());
        $this->addWorkAppOrder($builder, $orderField, $orderType);

        return $builder->getQuery()->getResult();
    }

    public function getNewWithOrder(string $orderField = '', string $orderType = 'asc'): array
    {
        $builder = $this->createQueryBuilder('w')
            ->andWhere('w.createdAt >= :date')
            ->setParameter('date', $this->getStartDate());
        $this->addWorkAppOrder($builder, $orderField, $orderType);

        return $builder->getQuery()->getResult();
    }

    private function addWorkAppOrder(QueryBuilder $builder, string $orderField, string $orderType): QueryBuilder
    {
        if ($orderField) {
            $builder->orderBy('w.' . $orderField, $orderType);
        }
        return $builder;
    }

    private function getStartDate(): \DateTime
    {
        return (new \DateTime())->setTime(0, 0, 0);
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
