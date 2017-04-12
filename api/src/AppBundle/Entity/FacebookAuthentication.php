<?php
/**
 * @author Kifah Abbad
 * Time: 16:50
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class FacebookAuthentication extends AuthenticationCredential
{

    /**
     * @ORM\Column(type="string")
     */
    private $facebookToken;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FacebookWebsite")
     * @ORM\JoinColumn(name="facebook_website_id")
     */
    private $facebookWebsite;

    /**
     * @return mixed
     */
    public function getFacebookToken()
    {
        return $this->facebookToken;
    }

    /**
     * @param mixed $facebookToken
     */
    public function setFacebookToken($facebookToken)
    {
        $this->facebookToken = $facebookToken;
    }

    /**
     * @return mixed
     */
    public function getFacebookWebsite()
    {
        return $this->facebookWebsite;
    }

    /**
     * @param mixed $facebookWebsite
     */
    public function setFacebookWebsite($facebookWebsite)
    {
        $this->facebookWebsite = $facebookWebsite;
    }




}