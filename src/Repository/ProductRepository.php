<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\PriceSearch;
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

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function filterbyprice($priceFrom,$priceTo) {
      
       
        $query= $this->createQueryBuilder('p');
        
        if ($priceFrom != null) {
            $query->where('p.price >= :priceFrom');
            $query ->andWhere('p.price < :priceTo');
            $query ->setParameter('priceFrom', $priceFrom);
            $query ->setParameter('priceTo', $priceTo);
        }
        
       
        return $query->getQuery()->getResult();

        //$entityManager = $this->getEntityManager();
        
        //$query = $entityManager->createQuery(
            
        //    'SELECT p
        //    FROM App\Entity\Product p
        //    WHERE p.price >= 10
        //    AND p.price <30
        //    ORDER BY p.price ASC'
            
        //);
        
        

        // returns an array of Product objects
        //return $query->getResult();
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
