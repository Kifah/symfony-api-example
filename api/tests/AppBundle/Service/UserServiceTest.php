<?php
/**
 * @author Kifah Abbad
 * Time: 17:45
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserServiceTest extends TestCase
{


    /**
     * @test
     */
    public function generateTokenWorks()
    {
        $username = 'foo';
        $password = 'kalnaswa';
        $token = 'my_token';
        $mail = 'mail@dot.com';
        $expectedReturnArray = ['username' => $username, 'token' => $token, 'email' => $mail];
        $user = Mockery::mock(User::class);
        $repo = Mockery::mock(EntityRepository::class);
        $em = Mockery::mock(EntityManager::class);
        $passwordEncoder = Mockery::mock(UserPasswordEncoderInterface::class);
        $encoder = Mockery::mock(JWTEncoderInterface::class);
        $em->shouldReceive('getRepository')->once()->andReturn($repo);
        $repo->shouldReceive('findOneBy')->once()->andReturn($user);
        $userService = new UserService($em, $passwordEncoder, $encoder);
        $passwordEncoder->shouldReceive('isPasswordValid')->andReturn(true);
        $user->shouldReceive('getUsername')->once()->andReturn($username);
        $user->shouldReceive('getEmail')->once()->andReturn($mail);
        $user->shouldReceive('setToken')->once()->with($token);
        $user->shouldReceive('getToken')->once()->andReturn($token);
        $encoder->shouldReceive('encode')->once()->andReturn($token);
        $tokenArray = $userService->generateUserToken($username, $password);
        $this->assertEquals($expectedReturnArray, $tokenArray);
    }

    /**
     * @test
     * @expectedException Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function generateTokenGeneratesException()
    {
        $username = 'foo';
        $password = 'kalnaswa';
        $user = Mockery::mock(User::class);
        $repo = Mockery::mock(EntityRepository::class);
        $em = Mockery::mock(EntityManager::class);
        $passwordEncoder = Mockery::mock(UserPasswordEncoderInterface::class);
        $encoder = Mockery::mock(JWTEncoderInterface::class);
        $em->shouldReceive('getRepository')->once()->andReturn($repo);
        $repo->shouldReceive('findOneBy')->once()->andReturnNull();
        $userService = new UserService($em, $passwordEncoder, $encoder);
        $token = $userService->generateUserToken($username, $password);
    }

    /**
     * @test
     * @expectedException Symfony\Component\Security\Core\Exception\BadCredentialsException
     */
    public function generateTokenBadCredentials()
    {
        $username = 'foo';
        $password = 'kalnaswa';
        $user = Mockery::mock(User::class);
        $repo = Mockery::mock(EntityRepository::class);
        $em = Mockery::mock(EntityManager::class);
        $passwordEncoder = Mockery::mock(UserPasswordEncoderInterface::class);
        $encoder = Mockery::mock(JWTEncoderInterface::class);
        $em->shouldReceive('getRepository')->once()->andReturn($repo);
        $repo->shouldReceive('findOneBy')->once()->andReturn($user);
        $userService = new UserService($em, $passwordEncoder, $encoder);
        $passwordEncoder->shouldReceive('isPasswordValid')->andReturn(false);
        $token = $userService->generateUserToken($username, $password);
        $this->assertEquals('my_token', $token);
    }

}
