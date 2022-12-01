<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 *
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function save(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Evenement[] Returns an array of Evenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evenement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    function geteByTypevenet($idtype){
        return $this->createQueryBuilder('e')
            ->join('e.typeEvenement','t')
            ->addSelect('t')
            ->where('t.id=:i')
            ->setParameter('i',$idtype)
            ->getQuery()->getResult()
            ;
    }
    public function gettotalDon(){
        $em=$this->getEntityManager();
        $qb=$em->createQuery("SELECT SUM(E.montant_recole) FROM APP\Entity\Evenement E");
        return $qb->getSingleScalarResult();
    }
    public function getDon($id){
        $em=$this->getEntityManager();
        $qb=$em->createQuery("SELECT E.montant_recole FROM APP\Entity\Evenement E where E.id = :x")
            ->setParameter('x',$id);
        return $qb->getSingleScalarResult();
    }

    public function gettopDonName() {
        $qb=  $this->createQueryBuilder('e')
            ->orderBy('e.montant_recole','DESC')
            ->setMaxResults(1);
        return $qb ->getQuery()
            ->getSingleResult();
    }

    public function gettopDonV(){
        $em=$this->getEntityManager();
        $qb=$em->createQuery("SELECT SUM(e.montant_recole) FROM APP\Entity\Evenement e order by e.montant_recole DESC");
        return $qb->getQuery()
            ->getResult();
    }

    public function getlastDonV(){
        $em=$this->getEntityManager();
        $qb=$em->createQuery("SELECT SUM(e.montant_recole) FROM APP\Entity\Evenement e order by e.montant_recole ASC");
        return $qb->getSingleScalarResult();
    }


    public function getMonByTyev() {
        $qb=  $this->createQueryBuilder('e')
            ->having('e.montant_recole');
        return $qb->getQuery()
            ->getResult();
    }



}
