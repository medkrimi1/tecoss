<?php

namespace App\Repository;
use App\Data\SearchData;
use App\Entity\TypeJobs;
use App\Entity\Jobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Jobs>
 *
 * @method Jobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jobs[]    findAll()
 * @method Jobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jobs::class);
    }

    public function add(Jobs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Jobs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


      public function findAll()
    {
        return $this->findBy(array(), array('id' => 'DESC'));
    }
        public function countAllJobs()
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->select('COUNT(a.id) as value');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

  /** 
     * 
     * @return jobs[]
     */
    public function findSearch(SearchData $search): array
    { 
         $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
             ->orderBy('p.id', 'DESC')
            ->join('p.skills', 'c');


        if (!empty($search->Title)) {
            $query = $query
                ->andWhere('p.id IN (:Title)')
                ->setParameter('Title', $search->Title);
        }
        if ((!empty($search->startdate))AND(!empty($search->enddate)) ) {
            $query = $query
                ->andWhere('p.CreatedAt BETWEEN (:startdate) AND (:enddate)')
                ->setParameter('startdate', $search->startdate)
                ->setParameter('enddate', $search->enddate);
        }
         if (!empty($search->TypeJobs)) {
            $query = $query
                ->andWhere('p.typeid IN (:TypeJobs)')
                ->setParameter('TypeJobs', $search->TypeJobs);
        }
        if (!empty($search->Experience)) {
            $query = $query
                ->andWhere('p.exp IN (:Experience)')
                ->setParameter('Experience', $search->Experience);

        }

          if (!empty($search->Skills)) {
            $query = $query
                ->andWhere('c.id IN (:Skills)')
                ->setParameter('Skills', $search->Skills);
        }
         

        

   
    return $query->getQuery()->getResult();
    }

//    /**
//     * @return Jobs[] Returns an array of Jobs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Jobs
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
