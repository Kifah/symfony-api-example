<?php
/**
 * @author Kifah Abbad
 * Time: 17:09
 */

namespace AppBundle\Service;


use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use PHPUnit\Framework\TestCase;

class DatabasePurgerTest extends TestCase
{

    /**
     * @test
     * @group DatabasePurgerTest
     */
    public function purgerOnTestEnv()
    {
        $Ormperger = \Mockery::mock(ORMPurger::class);
        $env = 'test';
        $Ormperger->shouldReceive('purge')->once();
        $perger = new DatabasePurger($Ormperger, $env);
        $perged = $perger->purgeDatabase();
        $this->assertTrue($perged);
    }

    /**
     * @test
     * @group DatabasePurgerTest
     */
    public function purgerOnLivetEnv()
    {
        $Ormperger = \Mockery::mock(ORMPurger::class);
        $env = 'prod';
        $Ormperger->shouldReceive('purge')->once();
        $perger = new DatabasePurger($Ormperger, $env);
        $perged = $perger->purgeDatabase();
        $this->assertFalse($perged);
    }

}
