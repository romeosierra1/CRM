<?php

namespace App\Controller;

use SBCamp\CRMBundle\Service\CRMLeads;
use SBCamp\ElasticSearchBundle\Service\ElasticSearchConnection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ElasticController extends Controller
{
    /**
     * @Route("index/")
     */
    public function index()
    {
        return $this->render('elastic/index.html.twig');
    }

    /**
     * @Route("index/create")
     */
    public function createIndex()
    {
        /**
         * @var ElasticSearchConnection $conn
         */
        $conn = $this->container->get('sbcamp.es.conn');
        $create = $conn->createIndex('lead', 'lead', array());
        return $this->render('elastic/result.html.twig', array("result" => $create->execute()->getStatus()));
    }

    /**
     * @Route("index/delete")
     */
    public function deleteIndex()
    {
        /**
         * @var ElasticSearchConnection $conn
         */
        $conn = $this->container->get('sbcamp.es.conn');
        $result = $conn->deleteIndex('lead', 'lead');
        return $this->render('elastic/result.html.twig', array("result" => $result->execute()->getStatus()));
    }

    /**
     * @Route("index/update")
     */
    public function updateIndex()
    {
        /**
         * @var ElasticSearchConnection $conn
         */
        $conn = $this->container->get('sbcamp.es.conn');

        /**
         * @var CRMLeads $leads
         */
        $leads = $this->container->get('sbcamp.crm.leads');
        $result = $conn->updateMapping('lead', 'lead', $leads->createLeadsMapping()->create());
        return $this->render('elastic/result.html.twig', array("result" => $result->execute()->getStatus()));
    }
}