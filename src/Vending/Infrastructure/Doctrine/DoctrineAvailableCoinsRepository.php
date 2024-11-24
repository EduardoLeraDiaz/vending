<?php

namespace App\Vending\Infrastructure\Doctrine;

use App\Common\Domain\Exception\EntityNotFoundException;
use App\Vending\Domain\Entity\AvailableCoin;
use App\Vending\Domain\Exception\NotEnoughCoinsExceptions;
use App\Vending\Domain\Repository\AvailableCoinsRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AvailableCoin>
 */
class DoctrineAvailableCoinsRepository extends ServiceEntityRepository implements AvailableCoinsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvailableCoin::class);
    }

    /** @return AvailableCoin[] */
    public function getPurse(): array {
        return $this->findBy([], ['centsValue' => 'DESC']);
    }

    /** @throws EntityNotFoundException */
    public function getAmountByCentValue(int $cents): int
    {
        /** @var AvailableCoin $availableCoins */
        $availableCoins = $this->findOneBy(['centsValue' => $cents]);
        if (is_null($availableCoins)) {
            throw new EntityNotFoundException('Type of coin not found');
        }

        return $availableCoins->getAmount();
    }

    /** @throws NotEnoughCoinsExceptions */
    public function changeAmount(int $cents, int $variation): void
    {
        /** @var AvailableCoin $availableCoins */
        $availableCoins = $this->findOneBy(['centsValue' => $cents]);
        if (is_null($availableCoins)) {
            $availableCoins = new AvailableCoin($cents, 0);
        }

        $availableCoins->setAmount($availableCoins->getAmount() + $variation);
        if ($availableCoins->getAmount() < 0) {
            throw new NotEnoughCoinsExceptions($cents);
        }
        $this->getEntityManager()->persist($availableCoins);
        $this->getEntityManager()->flush();
    }
}