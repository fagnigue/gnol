<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getWineProduct()
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = $queryvin = "SELECT 
                            product.id, 
                            product.label, 
                            product.image_url,
                            product.price 
                            FROM 
                            product INNER JOIN sous_category
                            ON product.souscategorie_id = sous_category.id
                            INNER JOIN category 
                            ON sous_category.categorie_id = category.id
                            WHERE category.label = 'Vin';";
        $stmt = $connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }

    public function getChampagneProduct()
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = $queryvin = "SELECT 
                            product.id, 
                            product.label, 
                            product.image_url,
                            product.price 
                            FROM 
                            product INNER JOIN sous_category
                            ON product.souscategorie_id = sous_category.id
                            INNER JOIN category 
                            ON sous_category.categorie_id = category.id
                            WHERE category.label = 'Champagne';";
        $stmt = $connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }

    public function getSpiritueuxProduct()
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = $queryvin = "SELECT 
                            product.id, 
                            product.label, 
                            product.image_url,
                            product.price 
                            FROM 
                            product INNER JOIN sous_category
                            ON product.souscategorie_id = sous_category.id
                            INNER JOIN category 
                            ON sous_category.categorie_id = category.id
                            WHERE category.label = 'Spiritueux';";
        $stmt = $connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }








    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
