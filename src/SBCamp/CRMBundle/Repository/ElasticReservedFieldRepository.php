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

}
