<?php

namespace SBCamp\CRMBundle\ElasticFields;

use Doctrine\Common\Persistence\ManagerRegistry;
use SBCamp\CRMBundle\Entity\ElasticReservedField;
use SBCamp\CRMBundle\Repository\ElasticReservedFieldRepository;

class CreateElasticSearchMapping
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * CreateElasticSearchMapping constructor.
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     */
    public function create():array
    {
        /**
         * @var ElasticReservedFieldRepository $elasticReservedFieldRepository
         */
        $elasticReservedFieldRepository = $this->doctrine->getRepository(ElasticReservedField::class);

        $elasticReservedFields = $elasticReservedFieldRepository->findAll();

        $mapping = array();

        //$mapping['uid'] = array('type', 'fields');
        foreach ($elasticReservedFields as $elasticReservedField) {
            $mapping[$elasticReservedField->getElasticFieldName()] = array('type' => $elasticReservedField->getDataType());
        }

        return $mapping;
    }
}