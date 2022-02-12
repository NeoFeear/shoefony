<?php

namespace App\Repository\Store;

use App\Entity\Store\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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

    /**
     * @return Product[]
     */
    public function findAllWithDetails(): array {
        $qb = $this->createQueryBuilder('p');

        $this->addJoinImage($qb);

        return $qb->getQuery()->getResult();
    }

    public function findOneWithDetails(int $id): ?Product {
        $qb = $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id);

        $this->addJoinImage($qb);
        $this->addJoinComments($qb);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return Product[]
     */
    public function findLastProducts(int $limit) {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit);
            
        $this->addJoinImage($qb);
            
        return $qb->getQuery()->getResult();
    }

    /**
     * @return Product[]
     */
    public function findMostCommentedProducts(int $limit) {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.comments', 'c')
            ->groupBy('p')
            ->orderBy('COUNT(c.id)', 'DESC')
            ->setMaxResults($limit);
        
        $this->addJoinImage($qb);

        return $qb->getQuery()->getResult();
    }

    /**
     * @return Product[]
     */
    public function findByBrand(int $brandId) {
        return $this->createQueryBuilder('p')
            ->where('p.brand =' . $brandId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Product[]
     */
    private function addJoinImage(QueryBuilder $queryBuilder) {
        return $queryBuilder
            ->addSelect('i')
            ->innerJoin('p.image', 'i');
    }

    /**
     * @return Product[]
     */
    private function addJoinComments(QueryBuilder $queryBuilder) {
        return $queryBuilder
            ->addSelect('c')
            ->leftJoin('p.comments', 'c');
    }

    // /**
    // * @return Product[] Returns an array of Product objects
    // */

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
