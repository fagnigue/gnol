<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function getOneClient(string $email)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT
                client.id,
                client.firstname,
                client.lastname,
                client.password,
                client.email,
                client.telephone,
                client.photo,
                client.country_id,
                client.adresse,
                client.info_sup,
                client.genre
                FROM
                client 
                WHERE client.email = :email;";
        $stmt = $connection->prepare($sql);
        $stmt->execute(["email"=>$email]);

        return $stmt->fetchAllAssociative();
    }

    public function getOneClientById(int $id)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT
                client.id,
                client.firstname,
                client.lastname,
                client.password,
                client.email,
                client.telephone,
                client.country_id,
                client.photo,
                client.adresse,
                client.info_sup,
                client.genre
                FROM
                client 
                WHERE client.id = :id;";
        $stmt = $connection->prepare($sql);
        $stmt->execute(["id"=>$id]);

        return $stmt->fetchAllAssociative();
    }

    // /**
    //  * @return Client[] Returns an array of Client objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
