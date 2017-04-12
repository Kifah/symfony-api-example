<?php
/**
 * @author Kifah Abbad
 * Time: 15:06
 */

namespace AppBundle\Entity;



use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 */
class FacebookWebsite extends Website
{


    /**
     * @ORM\Column(type="string")
     */
    private $tokenParameter;

    /**
     * @return mixed
     */
    public function getTokenParameter()
    {
        return $this->tokenParameter;
    }

    /**
     * @param mixed $tokenParameter
     */
    public function setTokenParameter($tokenParameter)
    {
        $this->tokenParameter = $tokenParameter;
    }




}