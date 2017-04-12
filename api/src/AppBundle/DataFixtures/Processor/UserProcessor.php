<?php

namespace AppBundle\DataFixtures\Processor;

use AppBundle\Entity\User;
use Fidry\AliceDataFixtures\ProcessorInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserProcessor implements ProcessorInterface
{
    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @param PasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * Processes an object before it is persisted to DB.
     *
     * @param string $id Fixture ID
     * @param object $object
     *
     * @return
     */
    public function preProcess(string $id, $object)
    {
        if (false === $object instanceof User) {
            return;
        }

        $password=$this->passwordEncoder->encodePassword($object, $object->getPassword());
        $object->setPassword($password);

    }

    /**
     * Processes an object after it is persisted to DB.
     *
     * @param string $id Fixture ID
     * @param object $object
     *
     * @return
     */
    public function postProcess(string $id, $object)
    {
    }
}