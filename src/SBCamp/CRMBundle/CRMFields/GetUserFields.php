<?php

namespace SBCamp\CRMBundle\CRMFields;


use SBCamp\CRMBundle\Entity\LeadCustomField;
use SBCamp\CRMBundle\Repository\LeadCustomFieldRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class GetUserFields
{
    /**
     * @var string
     */
    private $uid;

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
     * GetUserFields constructor.
     * @param string $uid
     * @param ManagerRegistry $doctrine
     */
    public function __construct(string $uid, ManagerRegistry $doctrine)
    {
        $this->uid = $uid;
        $this->doctrine = $doctrine;
    }

    /**
     * @return LeadCustomField[]
     */
    public function getFields()
    {
        /**
         * @var LeadCustomFieldRepository $leadCustomFieldRepository
         */
        $leadCustomFieldRepository = $this->doctrine->getRepository(LeadCustomField::class);

        return $leadCustomFieldRepository->findAllFieldsForUser($this->uid);
    }
}