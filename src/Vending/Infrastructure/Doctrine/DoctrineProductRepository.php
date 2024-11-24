<?php

namespace App\Vending\Infrastructure\Doctrine;

use App\Common\Domain\Exception\EntityNotFoundException;
use App\Vending\Domain\Entity\Product;
use App\Vending\Domain\Repository\ProductRepositoryInterface;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function save(Product $product): void
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    /**
     * @param array<Product> $products
     */
    public function bulkSave(array $products): void {
        $this->truncate();

        foreach ($products as $product) {
            $this->getEntityManager()->persist($product);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getBySelector(string $selector): Product
    {
        $product = $this->findOneBy(['selector' => $selector]);

        return $product ?? throw new EntityNotFoundException('Product not found');
    }

    /**
     * @throws Exception
     */
    private function truncate(): void {
        $this->getEntityManager()
            ->getConnection()
            ->executeQuery(sprintf('DELETE FROM %s', $this->getClassMetadata()->getTableName()));
    }
}
