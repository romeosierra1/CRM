<?php

namespace SBCamp\CRMBundle\Service;

use Doctrine\Common\Persistence\ManagerRegistry;

class CRMLeadsFactory
{
    /**
     * @param int $global
     * @param int $string
     * @param int $number
     * @param int $date
     * @return CRMLeads
     */
//    public function getCRMLeadsObject(int $global, int $string, int $number, int $date): CRMLeads
//    {
//        return new CRMLeads($global, $string, $number, $date);
//    }

    /**
     * @param ManagerRegistry $doctrine
     * @param array $limits
     * @return CRMLeads
     */
    public function getCRMLeadsObject(ManagerRegistry $doctrine, array $limits)
    {
        return new CRMLeads($doctrine, $limits);
    }
}