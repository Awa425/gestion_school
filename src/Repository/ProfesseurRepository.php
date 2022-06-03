<?php

namespace App\Repository;

use App\Entity\Professeur;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Professeur>
 *
 * @method Professeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professeur[]    findAll()
 * @method Professeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfesseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Professeur::class);
    }

    public function add(Professeur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Professeur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //gérer le QueryBuilder de cette requête.
    private function getOrderQueryBuilder()
    {
        // Select the orders and their packages
        $queryBuilder = $this->createQueryBuilder('o')
            ->addSelect('p');

        // Add the package relation
        $queryBuilder->leftJoin('o.packages', 'p');

        // Add WHERE clause
        $queryBuilder->where('o.deleted = 0')
            ->andWhere('p.deleted = 0');

        //Return the QueryBuilder
        return $queryBuilder;
    }

    // gérer la récupération des résultats de la requête sous forme de pagination
    public function getOrders($page)
    {
        $pageSize = 10;
        $firstResult = ($page - 1) * $pageSize;

        $queryBuilder = $this->getOrderQueryBuilder();

        // Set the returned page
        $queryBuilder->setFirstResult($firstResult);
        $queryBuilder->setMaxResults($pageSize);

        // Generate the Query
        $query = $queryBuilder->getQuery();

        // Generate the Paginator
        $paginator = new Paginator($query, true);
        return $paginator;
    }

    //    /**
    //     * @return Professeur[] Returns an array of Professeur objects
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

    //    public function findOneBySomeField($value): ?Professeur
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
