<?php

namespace SBCamp\CRMBundle\Service;

use SBCamp\CRMBundle\CRMFields\CreateField;
use SBCamp\CRMBundle\CRMFields\CreateLeadObject;
use SBCamp\CRMBundle\CRMFields\DeleteLeadCustomField;
use SBCamp\CRMBundle\CRMFields\GetUserFields;
use SBCamp\CRMBundle\CRMFields\CreateSearchParameters;
use SBCamp\CRMBundle\ElasticFields\CreateElasticSearchMapping;
use SBCamp\CRMBundle\Entity\LeadCustomField;
use Doctrine\Common\Persistence\ManagerRegistry;

class CRMLeads
{
    /**
     * @var array
     */
    private $limits;

    public function getLimits(): array
    {
        return $this->limits;
    }

    /**
     * @var ManagerRegistry $doctrine
     */
    private $doctrine;

    /**
     * @return ManagerRegistry
     */
    public function getDoctrine(): ManagerRegistry
    {
        return $this->doctrine;
    }

    /**
     * CRMLeads constructor.
     * @param ManagerRegistry $doctrine
     * @param array $limits
     */
    public function __construct(ManagerRegistry $doctrine, array $limits)
    {
        $this->limits = $limits;
        $this->doctrine = $doctrine;
    }

    /**
     * @param string $uid
     * @param string $columnName
     * @param string $dataType
     * @param array|null $config
     * @return CreateField
     */
    public function createCustomField(string $uid, string $columnName, string $dataType, array $config = null)
    {
        return new CreateField($uid, $columnName, $dataType, $config, $this->limits, $this->doctrine);
    }

    /**
     * @return CreateElasticSearchMapping
     */
    public function createLeadsMapping()
    {
        return new CreateElasticSearchMapping($this->doctrine);
    }

    /**
     * @param string $uid
     * @return GetUserFields
     */
    public function getUserCustomFields(string $uid)
    {
        return new GetUserFields($uid, $this->doctrine);
    }

    /**
     * @param string $machineFieldName
     * @return DeleteLeadCustomField
     */
    public function deleteCustomField(string $machineFieldName)
    {
        return new DeleteLeadCustomField($machineFieldName, $this->doctrine);
    }

    /**
     * @param string $uid
     * @param array $data
     * @return CreateLeadObject
     */
    public function createLeadObject(string $uid, array $data)
    {
        return new CreateLeadObject($uid, $data, $this->doctrine);
    }

    /**
     * @param string $uid
     */
    public function getAllLeads(string $uid)
    {
        //To be implemented
    }

    /**
     * @param string $uid
     * @param array $data
     * @return CreateSearchParameters
     */
    public function createSearchParameters(string $uid, array $data)
    {
        return new CreateSearchParameters($uid, $data, $this->doctrine);
    }
}