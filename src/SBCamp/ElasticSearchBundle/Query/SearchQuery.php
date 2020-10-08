<?php

namespace SBCamp\ElasticSearchBundle\Query;

use Elastica\Client;
use Elastica\Query;
use Elastica\QueryBuilder;
use Elastica\ResultSet;
use Elastica\Search;

class SearchQuery
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
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var string
     */
    protected $term;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    protected $range;

    /**
     * @var array
     */
    protected $filter;

    /**
     * SearchQuery constructor.
     * @param Client $client
     * @param string $indexName
     * @param string $indexType
     */
    public function __construct(Client $client, string $indexName, string $indexType)
    {
        $this->client = $client;
        $this->indexName = $indexName;
        $this->indexType = $indexType;
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getIndexName(): string
    {
        return $this->indexName;
    }

    /**
     * @param string $indexName
     */
    public function setIndexName(string $indexName)
    {
        $this->indexName = $indexName;
    }

    /**
     * @return string
     */
    public function getIndexType(): string
    {
        return $this->indexType;
    }

    /**
     * @param string $indexType
     */
    public function setIndexType(string $indexType)
    {
        $this->indexType = $indexType;
    }

    /**
     * @return string
     */
    public function getTerm(): string
    {
        return $this->term;
    }

    /**
     * @param string $term
     */
    public function setTerm(string $term)
    {
        $this->term = $term;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public function getRange(): array
    {
        return $this->range;
    }

    /**
     * @param array $range
     */
    public function setRange(array $range)
    {
        $this->range = $range;
    }

    /**
     * @return array
     */
    public function getFilter(): array
    {
        return $this->filter;
    }

    /**
     * @param array $filter
     */
    public function setFilter(array $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return array
     */
    public function execute(): array
    {
        $index = $this->client->getIndex($this->indexName);
        $type = $index->getType($this->indexType);
        $search = new Search($this->client);

        $multiMatchQuery = $this->queryBuilder->query()->multi_match();
        $boolQuery = $this->queryBuilder->query()->bool();
        if($this->term != null && count($this->fields) > 0)
        {
            $multiMatchQuery->setQuery($this->term);
            $multiMatchQuery->setFields($this->fields);
            $boolQuery->addMust($multiMatchQuery);
        }
        $boolQuery->addFilter($this->queryBuilder->query()->term($this->filter[0]["term"]));
        //$boolQuery->addMust($this->filter);
        if(count($this->range) > 0)
        {
            $boolQuery->addMust($this->range);
        }
        $results = $search->addIndex($index)->addType($type)->setQuery($boolQuery)->search();
        $resultSet = array();
        foreach ($results as $result) {
            $resultSet[] = $result->getData();
        }
        return $resultSet;
    }
}