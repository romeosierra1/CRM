<?php

namespace SBCamp\CRMBundle\Repository;

use SBCamp\CRMBundle\Entity\ElasticReservedField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ElasticReservedField|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElasticReservedField|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElasticReservedField[]    findAll()
 * @method ElasticReservedField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElasticReservedFieldRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ElasticReservedField::class);
    }

    /**
     * @param string $dataType
     * @return ElasticReservedField[]
     */
    public function findElasticFieldsByDataType(string $dataType)
    {
        return $this->createQueryBuilder('ef')
            ->where('ef.dataType = :dataType')
            ->setParameter('dataType', $dataType)
            ->getQuery()
            ->getResult();

    }

    /**
     * @param string $elasticFieldName
     * @return ElasticReservedField
     */
    public function findElasticFieldByName(string $elasticFieldName)
    {
        return $this->createQueryBuilder('ef')
            ->where('ef.elasticFieldName = :elasticFieldName')
            ->setParameter('elasticFieldName', $elasticFieldName)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return ElasticReservedFields[] Returns an array of ElasticReservedFields objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ElasticReservedFields
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
