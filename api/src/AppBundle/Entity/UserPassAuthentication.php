<?php
/**
 * @author Kifah Abbad
 * Time: 16:52
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class UserPassAuthentication extends AuthenticationCredential
{

    /**
     * @ORM\Column(type="string")
     */
    private $username;


    /**
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UserPassWebsite")
     * @ORM\JoinColumn(name="user_pass_website_id")
     */
    private $userPassWebsite;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUserPassWebsite()
    {
        return $this->userPassWebsite;
    }

    /**
     * @param mixed $userPassWebsite
     */
    public function setUserPassWebsite($userPassWebsite)
    {
        $this->userPassWebsite = $userPassWebsite;
    }









}