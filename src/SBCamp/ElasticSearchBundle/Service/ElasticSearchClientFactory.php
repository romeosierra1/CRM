<?php

namespace SBCamp\ElasticSearchBundle\Service;

use Elastica\Client;

class ElasticSearchClientFactory
{
    /**
     * @param string $type
     * @param array $esConfig
     * @return ElasticSearchConnection
     */
    public function getConnection(string $type = 'default', array $esConfig): ElasticSearchConnection
    {
        return new ElasticSearchConnection(new Client($esConfig));
    }
}