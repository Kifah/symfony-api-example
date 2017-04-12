<?php
/**
 * @author Kifah Abbad
 * Time: 17:26
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity("website")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"facebook_website" = "FacebookWebsite", "user_pass_website" = "UserPassWebsite"})
 */
abstract class Website
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Serializer\Expose()
     * @ORM\Column(type="string", unique=true)
     */
    private $name;


    /**
     * @Serializer\Expose()
     * @ORM\Column(type="string", unique=true)
     */
    private $mainUrl;

    /**
     * @Serializer\Expose()
     * @ORM\Column(type="string")
     */
    private $loginPath;

    /**
     * @Serializer\Expose()
     * @ORM\Column(type="string")
     */
    private $logoutPath;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getMainUrl()
    {
        return $this->mainUrl;
    }

    /**
     * @param mixed $mainUrl
     */
    public function setMainUrl($mainUrl)
    {
        $this->mainUrl = $mainUrl;
    }

    /**
     * @return mixed
     */
    public function getLoginPath()
    {
        return $this->loginPath;
    }

    /**
     * @param mixed $loginPath
     */
    public function setLoginPath($loginPath)
    {
        $this->loginPath = $loginPath;
    }

    /**
     * @return mixed
     */
    public function getLogoutPath()
    {
        return $this->logoutPath;
    }

    /**
     * @param mixed $logoutPath
     */
    public function setLogoutPath($logoutPath)
    {
        $this->logoutPath = $logoutPath;
    }





}