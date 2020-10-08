<?php

namespace App\Controller;

use SBCamp\CRMBundle\Helper\FieldNameHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends Controller
{
    /**
     * @Route("test/random")
     */
    public function random()
    {
        echo FieldNameHelper::generateFieldName();
        return new Response();
    }

    /**
     * @Route("test/combo")
     */
    public function getAllCombinations()
    {
        $combinations = FieldNameHelper::seedElasticFieldNames();

        foreach ($combinations as $combination) {
            echo $combination;
        }

        return new Response();
    }
}
