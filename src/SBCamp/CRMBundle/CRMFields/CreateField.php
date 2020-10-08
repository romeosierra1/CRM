<?php

namespace SBCamp\CRMBundle\CRMFields;

use SBCamp\CRMBundle\ElasticFields\CreateElasticReservedField;
use SBCamp\CRMBundle\Entity\ElasticReservedField;
use SBCamp\CRMBundle\Entity\LeadCustomField;
use SBCamp\CRMBundle\Helper\CheckFieldUsageHelper;
use SBCamp\CRMBundle\Repository\ElasticReservedFieldRepository;
use SBCamp\CRMBundle\Repository\LeadCustomFieldRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CreateField
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
     * @var string
     */
    private $dataType;

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $limits;

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
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getLimits(): array
    {
        return $this->limits;
    }

    /**
     * @param array $limits
     */
    public function setLimits(array $limits)
    {
        $this->limits = $limits;
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
     * CreateField constructor.
     * @param string $uid
     * @param string $columnName
     * @param string $dataType
     * @param array|null $config
     * @param array $limits
     * @param ManagerRegistry $doctrine
     */
    public function __construct(string $uid, string $columnName, string $dataType, array $config = null, array $limits, ManagerRegistry $doctrine)
    {
        $this->uid = $uid;
        $this->columnName = $columnName;
        $this->dataType = $dataType;
        $this->config = $config;
        $this->limits = $limits;
        $this->doctrine = $doctrine;
    }

    /**
     * @return LeadCustomField|\Exception
     */
    public function create()
    {
        /**
         * @var LeadCustomFieldRepository $leadCustomFieldRepository
         */
        $leadCustomFieldRepository = $this->doctrine->getRepository(LeadCustomField::class);

        /**
         * @var ElasticReservedFieldRepository $elasticReservedFieldRepository
         */
        $elasticReservedFieldRepository = $this->doctrine->getRepository(ElasticReservedField::class);

        $tuple = $leadCustomFieldRepository->findFieldForUser($this->uid, $this->columnName);
        if ($tuple != null) {
            return new \Exception('Tuple already exists');
        } else {
            $allUserFields = $leadCustomFieldRepository->findAllFieldsForUser($this->uid);
            if (count($allUserFields) < intval($this->limits['global'])) {
                $userTypeFields = $leadCustomFieldRepository->findDataTypeFieldsForUser($this->uid, $this->dataType);
                if (count($userTypeFields) < intval($this->limits[$this->dataType])) {
                    $elasticFields = $elasticReservedFieldRepository->findElasticFieldsByDataType($this->dataType);
                    foreach ($elasticFields as $elasticField) {
                        $used = CheckFieldUsageHelper::isUsedByUser($elasticField, $userTypeFields);
                        if (!$used) {
                            $crmField = new CreateLeadCustomField($this->uid, $this->columnName, $elasticField, $this->doctrine);
                            return $crmField->createLeadCustomField();
                        }
                    }
                    $elasticField = new CreateElasticReservedField($this->doctrine,$this->dataType);
                    $crmField = new CreateLeadCustomField($this->uid, $this->columnName, $elasticField->createElasticField(), $this->doctrine);
                    return $crmField->createLeadCustomField();
                } else {
                    return new \Exception('Limit reached for dataType->' . $this->dataType . ' for user->' . $this->uid);
                }
            } else {
                return new \Exception('Global limit reached for user->' . $this->uid);
            }
        }
    }
}