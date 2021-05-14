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

    public function getProductByCategory(string $category)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT 
                product.id, 
                product.label, 
                product.image_url,
                product.price 
                FROM 
                product INNER JOIN sous_category
                ON product.souscategorie_id = sous_category.id
                INNER JOIN category 
                ON sous_category.categorie_id = category.id
                WHERE category.label = :category;";
        $stmt = $connection->prepare($sql);
        $stmt->execute(["category"=>$category]);

        return $stmt->fetchAllAssociative();
    }

    public function getsouscategorie(string $category)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT
                sous_category.label
                FROM
                sous_category INNER JOIN category
                ON sous_category.categorie_id = category.id
                WHERE category.label = :category;";
        $stmt = $connection->prepare($sql);
        $stmt->execute(["category"=>$category]);

        return $stmt->fetchAllAssociative();
    }

    public function getProductBySouscategory(string $sous_category)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql= "SELECT
                product.id, 
                product.label, 
                product.image_url,
                product.price
                FROM
                product INNER JOIN sous_category
                ON product.souscategorie_id = sous_category.id
                WHERE sous_category.label = :sous_category;";
        $stmt = $connection->prepare($sql);
        $stmt->execute(["sous_category"=>$sous_category]);

        return $stmt->fetchAllAssociative();
    }

    public function getOneProduct (int $id)
    {

        $connection = $this->getEntityManager()->getConnection();

        $sql = "SELECT
                product.id,
                product.label,
                product.label_desc,
                product.price,
                product.bottle_type,
                product.description,
                product.image_url
                FROM
                product 
                WHERE product.id = :id;";
        $stmt = $connection->prepare($sql);
        $stmt->execute(["id"=>$id]);

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
