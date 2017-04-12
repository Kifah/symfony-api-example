<?php

/*
 * This file is part of the Fidry\AliceDataFixtures package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Fidry\AliceDataFixtures\Bridge\Symfony\Doctrine;

use Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundleTest as NakedFidryAliceDataFixturesBundleTest;
use Fidry\AliceDataFixtures\Bridge\Symfony\SymfonyApp\DoctrineKernel;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @coversNothing
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class FidryAliceDataFixturesBundleTest extends NakedFidryAliceDataFixturesBundleTest
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    public function setUp()
    {
        $this->kernel = DoctrineKernel::create();
        $this->kernel->boot();
    }

    public function tearDown()
    {
        $this->kernel->shutdown();
    }

    public function testServiceRegistration()
    {
        parent::testServiceRegistration();

        $this->assertServiceIsInstanceOf(
            \Fidry\AliceDataFixtures\Bridge\Doctrine\Purger\OrmPurger::class,
            'fidry_alice_data_fixtures.persistence.purger.doctrine.orm_purger'
        );

        $this->assertServiceIsInstanceOf(
            \Fidry\AliceDataFixtures\Bridge\Doctrine\Persister\ObjectManagerPersister::class,
            'fidry_alice_data_fixtures.persistence.persister.doctrine.object_manager_persister'
        );

        $this->assertServiceIsInstanceOf(
            \Fidry\AliceDataFixtures\Loader\PersisterLoader::class,
            'fidry_alice_data_fixtures.doctrine.persister_loader'
        );

        $this->assertServiceIsInstanceOf(
            \Fidry\AliceDataFixtures\Loader\PurgerLoader::class,
            'fidry_alice_data_fixtures.doctrine.purger_loader'
        );
    }
}
