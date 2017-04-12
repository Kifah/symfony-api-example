<?php
/**
 * @author Kifah Abbad
 * Time: 16:03
 */

namespace AppBundle\Service;


use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;

class DatabasePurger
{


    const ENVS = ['test', 'dev'];
    private $env;
    /**
     * @var ORMPurger
     */
    private $perger;

    /**
     * DatabasePurger constructor.
     * @param ORMPurger $perger
     * @param string $env
     */
    public function __construct(ORMPurger $perger, string $env)
    {
        $this->env = $env;
        $this->perger = $perger;
    }


    public function purgeDatabase(): bool
    {
        $purged = false;
        if (in_array($this->env, self::ENVS)) {
            $this->perger->purge();
            $purged = true;
        }
        return $purged;
    }


}