<?php

declare(strict_types=1);

namespace App\Tests\Api;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractApiTestCase extends KernelTestCase
{
    protected AbstractDatabaseTool $databaseTool;
    protected HttpClientInterface $client;
    protected ValidatorInterface $validator;
    protected EntityManagerInterface $entityManager;

    public function __construct()
    {
        self::bootKernel();

        $this->client = HttpClient::create([
            'base_uri' => 'http://6.1.0.2:80'
        ]);

        $this->validator = Validation::createValidator();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->databaseTool->setPurgeMode(
            ORMPurger::PURGE_MODE_TRUNCATE
        );

        $this->databaseTool->setExcludedDoctrineTables([
            'doctrine_migration_versions',
            'messenger_messages'
        ]);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);

        if (null === $entityManager) {
            throw new RuntimeException('Entity manager was not found in Api tests!');
        }

        $this->entityManager = $entityManager;

        parent::__construct();
    }
}
