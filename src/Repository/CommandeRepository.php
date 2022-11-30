<?php

namespace App\Repository;
//require('vendor\autoload.php')  ;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Twilio\Rest\Client ;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function save(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Commande[] Returns an array of Commande objects
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

//    public function findOneBySomeField($value): ?Commande
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function sendsms(): void
    {
        $sid = "ACff096b193c1c973816cf724a9c445180" ;
        $token = "1a05dcecbf89f071055d9ea6131946c7" ;
        $client = new Client ($sid, $token);

        $message = $client->messages
            ->create("+21654583665", // to
                ["body" => "  votre  commande est validé , ", "from" => "+18654247150"]
            );

    }

    public function sendsms2(): void
    {
        $sid = "ACff096b193c1c973816cf724a9c445180" ;
        $token = "1a05dcecbf89f071055d9ea6131946c7" ;
        $client = new Client ($sid, $token);

        $message = $client->messages
            ->create("+21654583665", // to
                ["body" => "  votre  commande est refusé  , ", "from" => "+18654247150"]
            );

    }

    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.status = :valideé')
            ->setParameter('valideé', $value)
            ->getQuery()
            ->getResult()
        ;
    }

}
