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

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
    public function findByPrice($min,$max): array
    {
       $products =  $this->createQueryBuilder('p')
            ->andWhere('p.price >= :min and p.price <= :max' )
            ->setParameter('min', $min)
            ->setParameter('max', $max)
            ->orderBy('p.id', 'ASC')
         //   ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
        return $products;
    }
    public function findByPrice2(int $min,int $max): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Product p
            WHERE p.price >= :min and p.price <= :max
            ORDER BY p.price ASC'
        )->setParameter(':min', $min)
         ->setParameter(':max', $max);

        // returns an array of Product objects
        return $query->getResult();
    }

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
