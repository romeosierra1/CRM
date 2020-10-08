<?php

namespace SBCamp\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SBCamp\CRMBundle\Repository\ElasticReservedFieldRepository")
 */
class ElasticReservedField
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $elasticFieldName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $dataType;

    public function getId()
    {
        return $this->id;
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
}
