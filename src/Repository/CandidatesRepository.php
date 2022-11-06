<?php

namespace App\Repository;
use App\Data\SearchDataCandidate;
use App\Entity\Candidates;
use App\Entity\Professions;
use App\Entity\Experience;
use App\Entity\Skills;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Candidates>
 *
 * @method Candidates|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidates|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidates[]    findAll()
 * @method Candidates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidates::class);
    }

    public function add(Candidates $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Candidates $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

        public function countAllCandidates()
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->select('COUNT(a.id) as value');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

     /** 
     * 
     * @return candidates[]
     */
    public function findSearchCandidate(SearchDataCandidate $search): array
    { 
         $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
             ->orderBy('p.id', 'DESC')
            ->join('p.skill', 'c');
             
          
       
       


        if (!empty($search->s)) {
             
            $query = $query
                ->andWhere('p.lname LIKE :s OR p.fname LIKE :s OR p.fullname LIKE :s
                   ') 
                ->setParameter('s', "%{$search->s}%");
        }

         if (!empty($search->email)) {
             
            $query = $query
                ->andWhere('p.email LIKE :email
                   ') 
                ->setParameter('email', "%{$search->email}%");
        }
         if (!empty($search->Professions)) {
            $query = $query
                ->andWhere('p.titre IN (:Professions)')
                ->setParameter('Professions', $search->Professions);
        }
         if (!empty($search->Experience)) {
            $query = $query
                ->andWhere('p.experience IN (:Experience)')
                ->setParameter('Experience', $search->Experience);
        }


  if (!empty($search->Country)) {
            $query = $query
                ->andWhere('p.Country IN (:Country)')
                ->setParameter('Country', $search->Country);
        }
          if (!empty($search->Skills)) {
            foreach ($search->Skills  as $k=> $skills)
            $query = $query
                ->andwhere(":skills$k MEMBER OF p.skill")
               
                ->setParameter("skills$k", $skills);
        }


   
     return $query->getQuery()->getResult();
    }

//    /**
//     * @return Candidates[] Returns an array of Candidates objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Candidates
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
