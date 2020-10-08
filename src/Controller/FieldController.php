<?php

namespace App\Controller;

use SBCamp\CRMBundle\Entity\LeadCustomField;
use SBCamp\CRMBundle\Service\CRMLeads;
use SBCamp\ElasticSearchBundle\Service\ElasticSearchConnection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FieldController extends Controller
{
    /**
     * @Route("field/")
     */
    public  function index()
    {
        return $this->render('field/index.html.twig');
    }

    /**
     * @Route("field/create")
     * @param Request $request
     * @return Response
     */
    public function createField(Request $request)
    {
        if($request->request->get("uid") && $request->request->get("columnName") && $request->request->get("dataType")) {
            $uid = $request->request->get("uid");
            $columnName = $request->request->get("columnName");
            $dataType = $request->request->get("dataType");

            /**
             * @var CRMLeads $leads
             */
            $leads = $this->container->get('sbcamp.crm.leads');
            $result = $leads->createCustomField($uid, $columnName, $dataType)->create();
            /**
             * @var ElasticSearchConnection $conn
             */
            $conn = $this->container->get('sbcamp.es.conn');
            $conn->updateMapping('lead', 'lead', $leads->createLeadsMapping()->create())->execute();
            if (is_a($result, '\Exception')) {
                //echo $result->getMessage();
                return $this->render('field/create.html.twig', array("message" => $result->getMessage()));
            } else {
                return $this->render('/field/create.html.twig', array("message" => "Field Created"));
            }
        } else {
            return $this->render('field/create.html.twig', array("message" => ""));
        }
    }

    /**
     * @Route("field/view")
     */
    public function viewField(Request $request)
    {
        if($request->request->get("uid")) {
            $uid = $request->request->get("uid");
            /**
             * @var CRMLeads $leads
             */
            $leads = $this->container->get('sbcamp.crm.leads');

            /**
             * @var LeadCustomField[]
             */
            $userFields = $leads->getUserCustomFields($uid)->getFields();

            $data = array();
            foreach ($userFields as $userField) {
                $data[] = array( "fieldName" => $userField->getMachineFieldName(), "columnName" => $userField->getColumnName());
            }

            return $this->render('field/view.html.twig', array("data" => $data));
        } else {
            return $this->render('field/view.html.twig', array("data" => array()));
        }
    }

    /**
     * @Route("field/delete/{slug}")
     */
    public function deleteField(Request $request, $slug)
    {
        /**
         * @var CRMLeads $leads
         */
        $leads = $this->container->get('sbcamp.crm.leads');
        $leads->deleteCustomField($slug)->delete();
        return $this->redirect('/field/view');
    }
}