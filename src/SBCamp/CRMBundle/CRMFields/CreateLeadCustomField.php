<?php

namespace SBCamp\CRMBundle\CRMFields;

use SBCamp\CRMBundle\Entity\ElasticReservedField;
use SBCamp\CRMBundle\Entity\LeadCustomField;
use SBCamp\CRMBundle\Helper\FieldNameHelper;
use SBCamp\CRMBundle\Repository\LeadCustomFieldRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CreateLeadCustomField
{
    /**
     * @var string
     */
    private $uid;

    /**
     * @var string
     */
    private $columnName;

    /**
     * @var ElasticReservedField
     */
    private $elasticField;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid(string $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    /**
     * @param string $columnName
     */
    public function setColumnName(string $columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * @return ElasticReservedField
     */
    public function getElasticField(): ElasticReservedField
    {
        return $this->elasticField;
    }

    /**
     * @param ElasticReservedField $elasticField
     */
    public function setElasticField(ElasticReservedField $elasticField)
    {
        $this->elasticField = $elasticField;
    }

    /**
     * @return ManagerRegistry
     */
    public function getDoctrine(): ManagerRegistry
    {
        return $this->doctrine;
    }

    /**
     * @param ManagerRegistry $doctrine
     */
    public function setDoctrine(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * CreateLeadCustomField constructor.
     * @param string $uid
     * @param string $columnName
     * @param ElasticReservedField $elasticField
     * @param ManagerRegistry $doctrine
     */
    public function __construct(string $uid, string $columnName, ElasticReservedField $elasticField, ManagerRegistry $doctrine)
    {
      $this->uid = $uid;
      $this->columnName = $columnName;
      $this->elasticField = $elasticField;
      $this->doctrine = $doctrine;
    }

    /**
     * @return LeadCustomField
     */
    public function createLeadCustomField()
    {
        /**
         *@var LeadCustomFieldRepository $leadCustomFieldRepository
         */
        $leadCustomFieldRepository = $this->doctrine->getRepository(LeadCustomField::class);

        $leadCustomField = new LeadCustomField();
        $leadCustomField->setUserId($this->uid);
        $leadCustomField->setColumnName($this->columnName);

        $machineFieldName = null;

        $generatedFieldNames = FieldNameHelper::seedElasticFieldNames();

        foreach ($generatedFieldNames as $fieldName) {
            if($leadCustomFieldRepository->findByMachineFieldName($this->uid.'s'. $fieldName) == null) {
                $machineFieldName = $this->uid.'s'. $fieldName;
                break;
            }
        }

        $leadCustomField->setMachineFieldName($machineFieldName);
        $leadCustomField->setElasticFieldName($this->elasticField->getElasticFieldName());
        $leadCustomField->setDataType($this->elasticField->getDataType());
        $leadCustomField->setType($this->elasticField->getDataType());

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($leadCustomField);
        $entityManager->flush();

        return $leadCustomField;
    }
}