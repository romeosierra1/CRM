<?php

namespace SBCamp\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SBCamp\CRMBundle\Repository\LeadCustomFieldRepository")
 */
class LeadCustomField
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private $userId;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private $columnName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $machineFieldName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $elasticFieldName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $dataType;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $config;

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getColumnName(): ?string
    {
        return $this->columnName;
    }

    public function setColumnName(string $columnName): self
    {
        $this->columnName = $columnName;

        return $this;
    }

    public function getMachineFieldName(): ?string
    {
        return $this->machineFieldName;
    }

    public function setMachineFieldName(string $machineFieldName): self
    {
        $this->machineFieldName = $machineFieldName;

        return $this;
    }

    public function getElasticFieldName(): ?string
    {
        return $this->elasticFieldName;
    }

    public function setElasticFieldName(string $elasticFieldName): self
    {
        $this->elasticFieldName = $elasticFieldName;

        return $this;
    }

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(string $dataType): self
    {
        $this->dataType = $dataType;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getConfig(): ?string
    {
        return $this->config;
    }

    public function setConfig(?string $config): self
    {
        $this->config = $config;

        return $this;
    }
}
