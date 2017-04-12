<?php
/**
 * @author Kifah Abbad
 * Time: 14:37
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller
{


    protected function jsonResponse($payload, int $responseCode = 200, Request $request = null)
    {


        $response = new Response(json_encode($payload), $responseCode);
//        $response->headers->set("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
        $response->headers->set('Content-Type', 'application/json');
//        //$response->headers->set('content-type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
//        $response->headers->set('Access-Control-Allow-Credentials', '*');
        $response->headers->set('Access-Control-Allow-Headers'
            ,
            'Access-Control-Allow-Headers,Origin, origin, accept, x-requested-with, X-Requested-With,Content-Type,Accept,content-type,Authorization,mytoken,X-Auth-Token');


        return $response;
    }


}