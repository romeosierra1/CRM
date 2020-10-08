<?php

namespace SBCamp\ElasticSearchBundle\Query;

use Elastica\Client;
use Elastica\Response;
use Elastica\Type\Mapping;

class CreateIndex
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $indexName;

    /**
     * @var string
     */
    protected $indexType;

    /**
     * @var array
     */
    protected $properties;

    /**
     * CreateIndex constructor.
     * @param Client $client
     * @param string $indexName
     * @param string $indexType
     * @param array $properties
     */
    public function __construct(Client $client, string $indexName, string $indexType, array $properties)
    {
        $this->client = $client;
        $this->indexName = $indexName;
        $this->indexType = $indexType;
        $this->properties = $properties;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $indexName
     */
    public function setIndexName(string $indexName)
    {
        $this->indexName = $indexName;
    }

    /**
     * @param string $indexType
     */
    public function setIndexType(string $indexType)
    {
        $this->indexType = $indexType;
    }

    /**
     * @param array $properties
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getIndexName(): string
    {
        return $this->indexName;
    }

    /**
     * @return string
     */
    public function getIndexType(): string
    {
        return $this->indexType;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @return Response
     */
    public function execute(): Response
    {
        $index = $this->client->getIndex($this->indexName);
        $index->create(array(), false);
        $type = $index->getType($this->indexType);
        $mapping = new Mapping();
        return $mapping->setType($type)->setProperties($this->properties)->send();
    }

}