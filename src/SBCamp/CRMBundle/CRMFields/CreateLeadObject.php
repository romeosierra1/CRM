<?php

namespace SBCamp\CRMBundle\CRMFields;

use SBCamp\CRMBundle\Entity\LeadCustomField;
use SBCamp\CRMBundle\Helper\ElasticFieldMappingHelper;
use SBCamp\CRMBundle\Repository\LeadCustomFieldRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CreateLeadObject
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
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
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
     * CreateLeadObject constructor.
     * @param string $uid
     * @param array $data
     * @param ManagerRegistry $doctrine
     */
    public function __construct(string $uid, array $data, ManagerRegistry $doctrine)
    {
        $this->uid = $uid;
        $this->data = $data;
        $this->doctrine = $doctrine;
    }

    public function create()
    {
        /**
         * @var LeadCustomFieldRepository $leadCustomFieldsRepository
         */
        $leadCustomFieldsRepository = $this->doctrine->getRepository(LeadCustomField::class);

        /**
         * @var LeadCustomField[]
         */
        $userFields = $leadCustomFieldsRepository->findAllFieldsForUser($this->uid);

        $newData = ElasticFieldMappingHelper::MapFromDoctrineToElasticFields($this->data, $userFields);
        $newData['uid'] = $this->uid;

        return $newData;
    }

}