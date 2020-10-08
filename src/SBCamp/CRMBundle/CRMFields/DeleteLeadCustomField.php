<?php

namespace SBCamp\CRMBundle\CRMFields;

use Doctrine\Common\Persistence\ManagerRegistry;
use SBCamp\CRMBundle\Entity\LeadCustomField;
use SBCamp\CRMBundle\Repository\LeadCustomFieldRepository;

class DeleteLeadCustomField
{
    /**
     * @var string
     */
    private $machineFieldName;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @return string
     */
    public function getMachineFieldName(): string
    {
        return $this->machineFieldName;
    }

    /**
     * @param string $machineFieldName
     */
    public function setMachineFieldName(string $machineFieldName)
    {
        $this->machineFieldName = $machineFieldName;
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

    public function __construct(string $machineFieldName, ManagerRegistry $doctrine)
    {
        $this->machineFieldName = $machineFieldName;
        $this->doctrine = $doctrine;
    }

    public function delete()
    {
        /**
         *@var LeadCustomFieldRepository $leadCustomFieldRepository
         */
        $leadCustomFieldRepository = $this->doctrine->getRepository(LeadCustomField::class);

        $entityManager = $this->doctrine->getManager();
        $entityManager->remove($leadCustomFieldRepository->findByMachineFieldName($this->machineFieldName));
        $entityManager->flush();
    }
}