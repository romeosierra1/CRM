<?php

namespace App\Controller;

use SBCamp\CRMBundle\CRMFields\CreateForm;
use SBCamp\CRMBundle\CRMFields\CreateSearchForm;
use SBCamp\CRMBundle\Helper\ElasticFieldMappingHelper;
use SBCamp\CRMBundle\Service\CRMLeads;
use SBCamp\ElasticSearchBundle\Service\ElasticSearchConnection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LeadController extends Controller
{
    /**
     * @Route("lead/")
     */
    public function index()
    {
        return $this->render("lead/index.html.twig");
    }

    /**
     * @Route("lead/create")
     */
    public function createLead(Request $request)
    {
        //$uid = $slug;
        $uid = "rajbir";
        /**
         * @var CRMLeads $leads
         */
        $leads = $this->container->get('sbcamp.crm.leads');
        $userFields = $leads->getUserCustomFields($uid)->getFields();
        $formCreator = new CreateForm($userFields, $this->createFormBuilder());
        $form = $formCreator->create();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leadData = $leads->createLeadObject($uid, $form->getData())->create();
            /**
             * @var ElasticSearchConnection $conn
             */
            $conn = $this->container->get('sbcamp.es.conn');
            $createLead = $conn->index('lead', 'lead');
            $createLead->addDocument($leadData);
            $createLead->execute();
            return $this->render('lead/create.html.twig', array(
                'form' => $form->createView(), 'message' => "Lead created"));

        }

        return $this->render('lead/create.html.twig', array(
            'form' => $form->createView(),
            'message' => ''
        ));
    }

    /**
     * @Route("lead/search")
     */
    public function searchLeads(Request $request)
    {
        $uid = "rajbir";
        //$uid = $slug;
        /**
         * @var CRMLeads $leads
         */
        $leads = $this->container->get('sbcamp.crm.leads');
        $userFields = $leads->getUserCustomFields($uid)->getFields();
        $formCreator = new CreateSearchForm($userFields, $this->createFormBuilder());
        $form = $formCreator->create();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leadData = $leads->createSearchParameters($uid, $form->getData())->create();
            /**
             * @var ElasticSearchConnection $conn
             */
            $conn = $this->container->get('sbcamp.es.conn');
            $search = $conn->search('lead', 'lead');
            $search->setTerm($leadData["query"]["term"]);
            $search->setFields($leadData["query"]["fields"]);
            $search->setRange($leadData["query"]["range"]);
            $search->setFilter($leadData["query"]["filter"]);
            $result = $search->execute();

            $result = ElasticFieldMappingHelper::MapFromElasticFieldsToDoctrine($result, $leads->getUserCustomFields($uid)->getFields());
            return $this->render('lead/search.html.twig', array(
                'form' => $form->createView(),
                'result' => $result
            ));

        }

        return $this->render('lead/search.html.twig', array(
            'form' => $form->createView(),
            'result' => array()
        ));
    }
}