<?php

namespace SBCamp\CRMBundle\CRMFields;

use Doctrine\Common\Persistence\ManagerRegistry;
use SBCamp\CRMBundle\Entity\LeadCustomField;
use SBCamp\CRMBundle\Helper\ElasticFieldMappingHelper;
use SBCamp\CRMBundle\Repository\LeadCustomFieldRepository;

class CreateSearchParameters
{
    /**
     * @var string
     */
    private $uid;

    /**
     * @var array
     */
    private $data;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(string $uid, array $data, ManagerRegistry $doctrine)
    {
        $this->uid = $uid;
        $this->data= $data;
        $this->doctrine = $doctrine;
    }

    public function create()
    {
        /**
         * @var LeadCustomFieldRepository $leadCustomFieldsRepository
         */
        $leadCustomFieldsRepository = $this->doctrine->getRepository(LeadCustomField::class);

        $userFields = $leadCustomFieldsRepository->findAllFieldsForUser($this->uid);

        $newData = ElasticFieldMappingHelper::MapFromDoctrineToElasticFieldsForSearch($this->data, $userFields);
        $newData["query"]["filter"][] = array("term" => array("uid" => $this->uid));
        return $newData;
    }
}