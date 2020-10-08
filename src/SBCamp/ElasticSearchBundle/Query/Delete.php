<?php

namespace SBCamp\ElasticSearchBundle\Query;

use Elastica\Client;
use Elastica\Response;

class Delete
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
     * @var
     */
    protected $id;

    /**
     * Delete constructor.
     * @param Client $client
     * @param string $indexName
     * @param string $indexType
     */
    public function __construct(Client $client, string $indexName, string $indexType)
    {
        $this->client = $client;
        $this->indexName = $indexName;
        $this->indexType = $indexType;
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
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getIndexName()
    {
        return $this->indexName;
    }

    /**
     * @return string
     */
    public function getIndexType()
    {
        return $this->indexType;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Response
     */
    public function execute(): Response
    {
        $index = $this->client->getIndex($this->indexName);
        $type = $index->getType($this->indexType);
        return $type->deleteById($this->id);
    }
}