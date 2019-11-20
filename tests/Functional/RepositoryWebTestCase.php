<?php declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Shared\Fixtures\FixturesDecorator;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

abstract class RepositoryWebTestCase extends WebTestCase
{
    use RefreshDatabaseTrait;

    protected $repository;
    protected $entityManager;
    protected $_fixtures;

    abstract protected function getRepositoryClass();

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->entityManager = $managerRegistry->getManager();

        $repositoryClass = $this->getRepositoryClass();
        $this->repository = new $repositoryClass($managerRegistry);
        $this->_fixtures = new FixturesDecorator(self::$fixtures);
    }

    public function fixtures(): FixturesDecorator
    {
        return $this->_fixtures;
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}