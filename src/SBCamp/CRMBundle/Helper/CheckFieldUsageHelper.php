<?php

namespace SBCamp\CRMBundle\Helper;

use SBCamp\CRMBundle\Entity\ElasticReservedField;

class CheckFieldUsageHelper
{
    /**
     * @param ElasticReservedField $elasticField
     * @param ElasticReservedField[] $userElasticFields
     * @return bool
     */
    public static function isUsedByUser(ElasticReservedField $elasticField, array $userElasticFields)
    {
        $result = false;

        foreach ($userElasticFields as $userElasticField) {
            if ($elasticField->getElasticFieldName() == $userElasticField->getElasticFieldName()) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}