<?php


namespace AppBundle\Security;


use AppBundle\Api\ApiProblem;
use AppBundle\Api\ResponseFactory;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JwtTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var JWTEncoderInterface
     */
    private $encoder;
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var ResponseFactory
     */
    private $responseFactory;


    /**
     * JwtTokenAuthenticator constructor.
     * @param JWTEncoderInterface $encoder
     * @param EntityManager $em
     * @param ResponseFactory $responseFactory
     */
    public function __construct(JWTEncoderInterface $encoder, EntityManager $em, ResponseFactory $responseFactory)
    {
        $this->encoder = $encoder;
        $this->em = $em;
        $this->responseFactory = $responseFactory;
    }

    public function getCredentials(Request $request)
    {
        $prefix = 'Bearer';
        $name = 'mytoken';
        $extractor = new AuthorizationHeaderTokenExtractor($prefix, $name);

        $token = $extractor->extract($request);

        if (!$token) {
            return;
        }

        return $token;
    }


    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $data = $this->encoder->decode($credentials);
        if ($data === false) {
            throw new CustomUserMessageAuthenticationException('Invalid token');
        }

        $username = $data['username'];

        $criteria = ['username' => $username];
        return $this->em->getRepository(User::class)->findOneBy($criteria);

    }

    public function checkCredentials($credentials, UserInterface $user)
    {

        return true;


    }


    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $apiProblem = new ApiProblem(401);
        // you could translate this
        $apiProblem->set('detail', $exception->getMessageKey());

        return $this->responseFactory->createResponse($apiProblem);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // Do nothing. Let Controller be called
    }


    public function supportsRememberMe()
    {
        return false;
    }


    public function start(Request $request, AuthenticationException $authException = null)
    {
        $problem = new ApiProblem(401);
        $message = $authException ? $authException->getMessageKey() : 'missing credentials';
        $problem->set('detail', $message);
        return $this->responseFactory->createResponse($problem);
    }
}