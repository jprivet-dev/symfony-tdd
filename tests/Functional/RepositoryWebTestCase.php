<?php declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\News;
use App\Tests\Shared\Exception\FixtureNotFoundException;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

abstract class RepositoryWebTestCase extends WebTestCase
{
    use RefreshDatabaseTrait;

    protected $repository;
    protected $entityManager;

    abstract protected function getRepositoryClass();

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->entityManager = $managerRegistry->getManager();

        $repositoryClass = $this->getRepositoryClass();
        $this->repository = new $repositoryClass($managerRegistry);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function getFixtureById(string $id)
    {
        if (key_exists($id, self::$fixtures)) {
            return self::$fixtures[$id];
        }

        throw new FixtureNotFoundException($id);
    }

    public function getNewsByFixtureId(string $id): News
    {
        return $this->getFixtureById($id);
    }
}