<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;


/**
 * @author Kifah Abbad
 * Time: 14:26
 */
class UserService
{

    const EXPIRIATION_IN_SECONDS = 3600;

    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * @var JWTEncoderInterface
     */
    private $JWTEncoder;

    public function __construct(
        EntityManager $em,
        UserPasswordEncoderInterface $passwordEncoder,
        JWTEncoderInterface $encoder
    ) {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->JWTEncoder = $encoder;
    }


    public function createUserFromArray(array $userArray):?User
    {
        $user = new User();
        $user->setUsername($userArray['username']);
        $user->setEmail($userArray['email']);
        $plainPassword = $userArray['password'];
        $encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }


    public function generateUserToken(string $username, string $password)
    {
        $entityRepository = $this->em->getRepository(User::class);
        $user = $entityRepository->findOneBy(['username' => $username]);

        if (!$user) {
            throw new UsernameNotFoundException();
        }
        $this->checkPassword($password, $user);
        $tokenData = ['username' => $user->getUsername(), 'exp' => time() + self::EXPIRIATION_IN_SECONDS];
        $token = $this->JWTEncoder->encode($tokenData);
        $user->setToken($token);
        $userArray = [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'token' => $user->getToken()
        ];

        return $userArray;
    }


    /**
     * @param string $password
     * @param User $user
     */
    private function checkPassword(string $password, User $user): void
    {
        $isValid = $this->passwordEncoder->isPasswordValid($user, $password);
        if (!$isValid) {
            throw new BadCredentialsException();
        }
    }

}