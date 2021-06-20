<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;
use RuntimeException;

/**
 * This context on each scenario creates new empty database.
 */
class DatabaseContext implements Context
{
    private SchemaTool $schemaTool;

    /** @var ClassMetadata[] */
    private array $classMetadatas;

    public function __construct(
        ManagerRegistry $managerRegistry
    ) {
        $entityManager = $managerRegistry->getManager();
        if (! $entityManager instanceof EntityManagerInterface) {
            throw new RuntimeException(
                'Object manager is not instance of class EntityManager. Please check your configuration.'
            );
        }

        $this->schemaTool     = new SchemaTool($entityManager);
        $this->classMetadatas = $entityManager->getMetadataFactory()->getAllMetadata();
    }

    /**
     * @throws ToolsException
     *
     * @BeforeScenario
     */
    public function createDatabase(): void
    {
        $this->schemaTool->dropDatabase();
        $this->schemaTool->createSchema($this->classMetadatas);
    }

    /**
     * @AfterScenario
     */
    public function dropDatabase(): void
    {
        $this->schemaTool->dropDatabase();
    }
}
