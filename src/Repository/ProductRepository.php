<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
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
    
    

    public function findByPrice($pmin,$pmax)
    {
        
        $requete = $this->createQueryBuilder('p')
                    ->andWhere('p.price >= :min and p.price <= :max')
                    ->setParameter('min', $pmin)
                    ->setParameter('max', $pmax)
                    ->orderBy('p.price', 'ASC')
                    ->getQuery();

        $products = $requete->getResult();
        return $products;

    }
    public function findByPrice2($pmin,$pmax)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Product p
            WHERE p.price >= :pmin and p.price <= :pmax
            ORDER BY p.price ASC'
        )->setParameter('pmin', $pmin)
         ->setParameter('pmax', $pmax);

        // returns an array of Product objects
        return $query->getResult();

    }
    public function findByPrice3(int $pmin,int $pmax): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM product p
            WHERE p.price >= :pmin and p.price <= :pmax
            ORDER BY p.price ASC
            ';

        $resultSet = $conn->executeQuery($sql, ['pmax' => $pmax,'pmin' => $pmin]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
