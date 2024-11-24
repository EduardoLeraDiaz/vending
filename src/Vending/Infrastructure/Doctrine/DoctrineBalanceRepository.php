<?php

namespace App\Vending\Infrastructure\Doctrine;

use App\Vending\Domain\Entity\Balance;
use App\Vending\Domain\Repository\BalanceRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Balance>
 */
class DoctrineBalanceRepository extends ServiceEntityRepository implements BalanceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Balance::class);
    }
    public function getBalance(): float
    {
        $balance = $this->findOneBy([]);
        if (is_null($balance)) {
            return 0;
        }

        return $balance->getAmount();
    }

    public function changeBalance(float $amount): void
    {
        $balance = $this->findOneBy([]);
        if (is_null($balance)) {
            $balance = new Balance(null, 0);
        }

        $balance->setAmount($balance->getAmount() + $amount);
        $this->getEntityManager()->persist($balance);
        $this->getEntityManager()->flush();
    }

    public function resetBalance(): void
    {
        $balance = $this->findOneBy([]);
        if (is_null($balance)) {
            $balance = new Balance(null, 0);
        }

        $balance->setAmount(0);
        $this->getEntityManager()->persist($balance);
        $this->getEntityManager()->flush();
    }
}
