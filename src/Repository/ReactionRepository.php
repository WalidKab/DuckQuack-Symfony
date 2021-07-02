<?php

namespace App\Repository;

use App\Entity\Quack;
use App\Entity\Reaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reaction[]    findAll()
 * @method Reaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reaction::class);
    }


    public function getQuackStatistics(Quack $quack) {
        $qb = $this->createQueryBuilder('r');
        return $qb->select('COUNT(r) as cnt, ar.emoji')
            ->join('r.availableReaction','ar')
            ->groupBy('r.availableReaction')
            ->andWhere('r.quack=:quack')
            ->setParameter(':quack',$quack->getId())
            ->getQuery()
            ->getScalarResult();

    }

    // /**
    //  * @return Reaction[] Returns an array of Reaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reaction
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
