<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use ReflectionException;
use ReflectionProperty;

class ProductContext implements Context
{
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * Adds products to the database.
     *
     * @param TableNode<string[]> $table
     *
     * @throws OptimisticLockException
     * @throws ORMException
     *
     * @example
     *    Given there are following products:
     *      | id  | name       | price |
     *      | 123 | Calculator | 14.22 |
     *      | 456 | Notebook   | 99.99 |
     *
     * @Given there are following products:
     */
    public function thereAreFollowingProducts(TableNode $table): void
    {
        $entityManager = $this->productRepository->getEntityManager();
        foreach ($table as $row) {
            $product = new Product();
            $this->setAssignedIdGenerator(Product::class);
            $this->setProperty($product, 'id', (int) $row['id']);
            $product->setName($row['name']);
            $product->setPrice((float) $row['price']);
            $entityManager->persist($product);
        }

        $this->productRepository->getEntityManager()->flush();
    }

    /**
     * @param mixed $value
     *
     * @throws ReflectionException
     */
    private function setProperty(object $object, string $name, $value): void
    {
        $prop = new ReflectionProperty($object, $name);
        $prop->setAccessible(true);
        $prop->setValue($object, $value);
    }

    private function setAssignedIdGenerator(string $className): void
    {
        $metadata                = $this->productRepository->getEntityManager()->getClassMetadata($className);
        $metadata->idGenerator   = new AssignedGenerator();
        $metadata->generatorType = ClassMetadataInfo::GENERATOR_TYPE_NONE;
        $this
            ->productRepository
            ->getEntityManager()
            ->getMetadataFactory()
            ->setMetadataFor(Product::class, $metadata);
    }
}
