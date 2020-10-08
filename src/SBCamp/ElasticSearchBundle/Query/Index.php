<?php

namespace SBCamp\ElasticSearchBundle\Query;

use Elastica\Bulk\ResponseSet;
use Elastica\Client;
use Elastica\Document;
use Symfony\Component\Config\Definition\Exception\Exception;

class Index
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
    protected $documents = [];

    /**
     * Index constructor.
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
     * @param $document
     */
    public function addDocument($data)
    {
        if (is_a($data, 'Elastica\Document')) {
            $this->documents[] = $data;
        } else {
            $document = new Document('', $data, $this->indexType, $this->indexName);
            $this->documents[] = $document;
        }
    }

    /**
     * @return array
     */
    public function getDocuments(): array
    {
        return $this->documents;
    }

    /**
     * @return \Elastica\Bulk\ResponseSet
     */
    public function execute(): ResponseSet
    {
        if (count($this->documents) == 0) {
            throw new Exception('Documents array is empty');
        } else {
            $type = $this->client->getIndex($this->indexName)->getType($this->indexType);
            $response = $type->addDocuments($this->documents);
            $type->getIndex()->refresh();
            return $response;
        }
    }
}