<?php

namespace SBCamp\CRMBundle\ElasticFields;

use SBCamp\CRMBundle\Entity\ElasticReservedField;
use SBCamp\CRMBundle\Helper\FieldNameHelper;
use SBCamp\CRMBundle\Repository\ElasticReservedFieldRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CreateElasticReservedField
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var string
     */
    private $dataType;

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
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * @param string $dataType
     */
    public function setDataType(string $dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * CreateElasticReservedField constructor.
     * @param ManagerRegistry $doctrine
     * @param string $dataType
     */
    public function __construct(ManagerRegistry $doctrine, string $dataType)
    {
        $this->doctrine  = $doctrine;
        $this->dataType = $dataType;
    }

    /**
     * @return ElasticReservedField
     */
    public function createElasticField()
    {
        $elasticFieldName = null;

        /**
         * @var ElasticReservedFieldRepository $elasticReservedFieldRepository
         */
        $elasticReservedFieldRepository = $this->doctrine->getRepository(ElasticReservedField::class);

        $generatedFieldNames = FieldNameHelper::seedElasticFieldNames();

        foreach ($generatedFieldNames as $fieldName) {
            if($elasticReservedFieldRepository->findElasticFieldByName($fieldName) == null) {
                $elasticFieldName = $fieldName;
                break;
            }
        }

        $elasticReservedField = new ElasticReservedField();
        $elasticReservedField->setElasticFieldName($elasticFieldName);
        $elasticReservedField->setDataType($this->dataType);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($elasticReservedField);
        $entityManager->flush();

        return $elasticReservedField;
    }
}