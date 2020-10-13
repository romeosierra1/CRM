<?php

namespace SBCamp\CRMBundle\Repository;

use SBCamp\CRMBundle\Entity\LeadCustomField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LeadCustomField|null find($id, $lockMode = null, $lockVersion = null)
 * @method LeadCustomField|null findOneBy(array $criteria, array $orderBy = null)
 * @method LeadCustomField[]    findAll()
 * @method LeadCustomField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeadCustomFieldRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LeadCustomField::class);
    }

    /**
     * @param string $uid
     * @return LeadCustomField[]
     */
    public function findAllFieldsForUser(string $uid)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.userId = :userId')
            ->setParameter('userId', $uid)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $uid
     * @param string $dataType
     * @return LeadCustomField[]
     */
    public function findDataTypeFieldsForUser(string $uid, string $dataType)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.userId = :userId')
            ->andWhere('l.dataType = :dataType')
            ->setParameter('userId', $uid)
            ->setParameter('dataType', $dataType)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $uid
     * @param string $columnName
     * @return LeadCustomField
     */
    public function findFieldForUser(string $uid, string $columnName)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.userId = :userId')
            ->andWhere('l.columnName = :columnName')
            ->setParameter('userId', $uid)
            ->setParameter('columnName', $columnName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $machineFieldName
     * @return LeadCustomField
     */
    public function findByMachineFieldName(string $machineFieldName)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.machineFieldName = :machineFieldName')
            ->setParameter('machineFieldName', $machineFieldName)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
