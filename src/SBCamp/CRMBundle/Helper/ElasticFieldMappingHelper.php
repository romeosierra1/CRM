<?php

namespace SBCamp\CRMBundle\Helper;

use SBCamp\CRMBundle\Entity\LeadCustomField;

class ElasticFieldMappingHelper
{
    /**
     * @param array $data
     * @param LeadCustomField[] $userFields
     * @return array
     */
    public static function MapFromDoctrineToElasticFields(array $data, array $userFields)
    {
        $newData = array();
        foreach ($data as $key => $value) {
            foreach ($userFields as $userField) {
                if ($userField->getColumnName() == $key) {
                    $newData[$userField->getElasticFieldName()] = $value;
                    break;
                }
            }
        }
        return $newData;
    }

    /**
     * @param array $data
     * @param LeadCustomField[] $userFields
     * @return array
     */
    public static function MapFromElasticFieldsToDoctrine(array $records, array $userFields)
    {
        $newRecords = array();
        foreach ($records as $record) {
            $newRecord = array();
            foreach ($record as $key => $value) {
                foreach ($userFields as $userField) {
                    if ($userField->getElasticFieldName() == $key) {
                        $newRecord[$userField->getColumnName()] = $value;
                        break;
                    }
                }
            }
            $newRecords[] = $newRecord;
        }
        return $newRecords;
    }

    /**
     * @param array $data
     * @param LeadCustomField[] $userFields
     * @return array
     */
    public static function MapFromDoctrineToElasticFieldsForSearchOld(array $data, array $userFields)
    {
        $terms = array();
        $range = array();
        foreach ($data as $key => $value) {
            if ($key == "term") {
                foreach ($userFields as $userField) {
                    if ($userField->getDataType() == "text") {
                        if ($value != null) {
                            array_push($terms, array("match" => array($userField->getElasticFieldName() => $value)));
                        }
                    }
                }
            } elseif ($key == "range") {
                foreach ($userFields as $userField) {
                    if ($value != null) {
                        if ($userField->getColumnName() == $value) {
                            array_push($range, array("range" => array($userField->getElasticFieldName() => array("gte" => $data["gte"], "lte" => $data["lte"]))));
                            break;
                        }
                    }
                }
            }
        }

        $newData["query"]["terms"] = $terms;
        $newData["query"]["range"] = $range;

        return $newData;
    }

    /**
     * @param array $data
     * @param LeadCustomField[] $userFields
     * @return array
     */
    public static function MapFromDoctrineToElasticFieldsForSearch(array $data, array $userFields)
    {
        $term = null;
        $fields = array();
        $range = array();
        foreach ($data as $key => $value) {
            if(boolval($value)) {
                if ($key == "term") {
                    $term = $value;
                } else {
                    foreach ($userFields as $userField) {
                        if ($key == $userField->getColumnName()) {
                            if ($userField->getDataType() == "text") {
                                $fields[] = $userField->getElasticFieldName();
                            } elseif ($userField->getDataType() == "date" || $userField->getDataType() == "double") {
                                array_push($range, array("range" => array($userField->getElasticFieldName() => array("gte" => $data[$userField->getColumnName()."_gte"], "lte" => $data[$userField->getColumnName()."_lte"]))));
                            }
                            break;
                        }
                    }
                }
            }
        }
        $newData["query"]["term"]  = $term;
        $newData["query"]["fields"] = $fields;
        $newData["query"]["range"] = $range;

        return $newData;
    }
}