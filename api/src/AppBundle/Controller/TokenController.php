<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends BaseController
{
    /**
     * @Route("/entry", name="free_entry")
     * @Method("GET")
     */
    public function openEntryAction()
    {
        $testArray = ['app' => 'symfony'];
        $data = $testArray;
        return $this->jsonResponse($data);
    }


    /**
     * @Route("/api/token", name="get_token")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function newTokenAction(Request $request): Response
    {
        $payload = $request->getContent();
        if (null === $payload) {
            throw new \Exception('Missing authentication payload');
        }
        $this->get('logger')->info('content of payload:'.$payload);
        $PayloadArray = json_decode($payload, true);
        $requestUser = $PayloadArray['username'];
        $requestPassword = $PayloadArray['password'];
        if (null === $requestUser || null === $requestPassword) {
            throw new \Exception('Missing authentication fields');
        }
        $authenticatedUser = $this->get('user_service')->generateUserToken($requestUser, $requestPassword);
        return $this->jsonResponse($authenticatedUser, 200, $request);

    }

}
