<?php
/**
 * @author Kifah Abbad
 * Time: 15:08
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class UserPassWebsite extends Website
{


    /**
     * @ORM\Column(type="string")
     */
    private $usernameSelector;


    /**
     * @ORM\Column(type="string")
     */
    private $passwordSelector;

    /**
     * @ORM\Column(type="string")
     */
    private $submitSelector;

    /**
     * @return mixed
     */
    public function getUsernameSelector()
    {
        return $this->usernameSelector;
    }

    /**
     * @param mixed $usernameSelector
     */
    public function setUsernameSelector($usernameSelector)
    {
        $this->usernameSelector = $usernameSelector;
    }

    /**
     * @return mixed
     */
    public function getPasswordSelector()
    {
        return $this->passwordSelector;
    }

    /**
     * @param mixed $passwordSelector
     */
    public function setPasswordSelector($passwordSelector)
    {
        $this->passwordSelector = $passwordSelector;
    }

    /**
     * @return mixed
     */
    public function getSubmitSelector()
    {
        return $this->submitSelector;
    }

    /**
     * @param mixed $submitSelector
     */
    public function setSubmitSelector($submitSelector)
    {
        $this->submitSelector = $submitSelector;
    }





}