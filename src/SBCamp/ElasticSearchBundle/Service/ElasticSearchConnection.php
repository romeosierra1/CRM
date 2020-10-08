<?php

namespace SBCamp\ElasticSearchBundle\Service;

use SBCamp\ElasticSearchBundle\Query\UpdateMapping;
use SBCamp\ElasticSearchBundle\Query\CreateIndex;
use SBCamp\ElasticSearchBundle\Query\Delete;
use SBCamp\ElasticSearchBundle\Query\DeleteIndex;
use SBCamp\ElasticSearchBundle\Query\Index;
use SBCamp\ElasticSearchBundle\Query\SearchQuery;
use Elastica\Client;

class ElasticSearchConnection
{
    private $client;

    /**
     * ElasticSearchConnection constructor.
     * @param Client $client
     */
    function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $indexName
     * @param string $indexType
     * @param array $mappingProperties
     * @return CreateIndex
     */
    function createIndex(string $indexName, string $indexType, array $mappingProperties)
    {
        return new CreateIndex($this->client, $indexName, $indexType, $mappingProperties);
    }

    /**
     * @param string $indexName
     * @param string $indexType
     * @return Index
     */
    function index(string $indexName, string $indexType)
    {
        return new Index($this->client, $indexName, $indexType);
    }

    /**
     * @param string $indexName
     * @param string $indexType
     * @return SearchQuery
     */
    function search(string $indexName, string $indexType)
    {
        return new SearchQuery($this->client, $indexName, $indexType);
    }

    /**
     * @param string $indexName
     * @param string $indexType
     * @return DeleteIndex
     */
    function deleteIndex(string $indexName, string $indexType)
    {
        return new DeleteIndex($this->client, $indexName, $indexType);
    }

    /**
     * @param string $indexName
     * @param string $indexType
     * @return Delete
     */
    function delete(string $indexName, string $indexType)
    {
        return new Delete($this->client, $indexName, $indexType);
    }

    /**
     * @param string $indexName
     * @param string $indexType
     * @param array $mapping
     * @return UpdateMapping
     */
    function updateMapping(string $indexName, string $indexType, array $mapping)
    {
        return new UpdateMapping($this->client, $indexName, $indexType, $mapping);
    }
}