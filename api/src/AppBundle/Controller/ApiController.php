<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class ApiController extends TokenController
{


    /**
     * @Route("/api/authenticated", name="authenticated_route")
     * @Method("GET")
     * @return Response
     */
    public function authenticatedAction()
    {
        $data = ['I_am' => 'token_protected'];
        return $this->jsonResponse($data);
    }

    /**
     * @Route("/api/users", name="get_users")
     * @return Response
     */
    public function agetAllUsersAction(Request $request)
    {
        $user1 = ['username' => 'foo', 'id' => 1, 'email' => 'foo@naswa.com'];
        $user2 = ['username' => 'naswa', 'id' => 2, 'email' => 'foo@naswa1.com'];
        $data = [$user1, $user2];
        return $this->jsonResponse($data, 200, $request);
    }


}
