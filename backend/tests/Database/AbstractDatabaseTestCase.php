<?php

declare(strict_types=1);

namespace App\Tests\Database;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractDatabaseTestCase extends KernelTestCase
{
    protected AbstractDatabaseTool $databaseTool;

    public function __construct()
    {
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->databaseTool->setPurgeMode(
            ORMPurger::PURGE_MODE_TRUNCATE
        );

        $this->databaseTool->setExcludedDoctrineTables([
            'doctrine_migration_versions',
            'messenger_messages'
        ]);

        parent::__construct();
    }
}
