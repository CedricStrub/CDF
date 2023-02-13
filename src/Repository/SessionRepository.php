<?php

namespace App\Repository;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function save(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findByStagiaire(Stagiaire $stagiaire, ManagerRegistry $doctrine)
    {
        $sessions = $doctrine->getRepository(Session::class)->findAll();
        $st = $stagiaire->getId();
        $data = [];
        foreach($sessions as $session ){
            $se = $session->getParticiper()->toArray();
            $i = 0;
            $in = 0;
            while($i < count($se)){
                if($st == $se[$i]->getId()){
                    $in = 1;
                }
                $i = $i + 1;
            }
            if($in == 1){
                $data []= $session;
            }
        }

        return $data;
    }

    public function findNonRegistered(Session $session, ManagerRegistry $doctrine)
    {
        $st1 = $session->getParticiper()->toArray();
        $st2 = $doctrine->getRepository(Stagiaire::class)->findAll();
        $i = 0;
        $data = [];
        while($i < count($st2)){
            $in = 0;
            $j = 0;
            while($j < count($st1)){
                if($st1[$j]->getId() == $st2[$i]->getId()){
                    $in = 1;
                }
                $j = $j + 1;
            }
            if($in == 0){
                $data []= $st2[$i];
            }
            $i = $i + 1;
        }
        return $data;
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
