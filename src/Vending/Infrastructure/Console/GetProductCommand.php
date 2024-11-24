<?php

namespace App\Vending\Infrastructure\Console;

use App\Common\Domain\Exception\EntityNotFoundException;
use App\Vending\Application\Command\AlterPurseRequest;
use App\Vending\Application\Command\SellProductRequest;
use App\Vending\Application\Query\CalculateCoinsForAmountRequest;
use App\Vending\Application\Query\CalculateCoinsForAmountResponse;
use App\Vending\Application\Query\GetBalanceRequest;
use App\Vending\Application\Query\GetBalanceResponse;
use App\Vending\Application\Query\GetProductsRequest;
use App\Vending\Application\Query\GetProductsResponse;
use App\Vending\Domain\Entity\Product;
use App\Vending\Domain\Exception\NotEnoughBalanceException;
use App\Vending\Domain\Exception\ProductSoldOutException;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'vending:get')]
class GetProductCommand extends Command
{
    private const VALUE_PARAMETER_NAME = 'product';
    public function __construct(private CommandBus $commandBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Buy one product using the actual balance')
            ->setHelp('If you have enough money, it give the product and the rest of the money')
            ->addArgument(self::VALUE_PARAMETER_NAME, InputArgument::REQUIRED, 'The selector of the product.');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        # Check if the operation is possible
        $selector = $input->getArgument(self::VALUE_PARAMETER_NAME);
        try {
            $product = $this->findProduct($selector);
        } catch(EntityNotFoundException) {
            $output->writeln('Product not found');
            return Command::SUCCESS;
        }

        /** @var GetBalanceResponse $balanceResponse */
        $balanceResponse = $this->commandBus->handle(new GetBalanceRequest());
        $preBalance = $balanceResponse->balance;
        if ($preBalance < $product->getPrice()) {
            $output->writeln('Not enough money');
            return Command::SUCCESS;
        }

        /** @var CalculateCoinsForAmountResponse $coinResponse */
        $coinResponse = $this->commandBus->handle(new CalculateCoinsForAmountRequest($preBalance - $product->getPrice()));
        if ($coinResponse->remain !=0 ) {
            $output->writeln('Out of change: Exact amount required.');
            return Command::SUCCESS;
        }

        try {
            $this->commandBus->handle(new SellProductRequest($selector));
        } catch(ProductSoldOutException) {
            $output->writeln('Product sold out, select another product');
            return Command::SUCCESS;
        } catch(NotEnoughBalanceException) {
            $output->writeln('Not enough money');
            return Command::SUCCESS;
        }

        $output->writeln('Vend item '.$product->getName());

        # Return money
        $this->commandBus->handle(AlterPurseRequest::fromCoins($coinResponse->coins));
        foreach($coinResponse->coins as $coin) {
            $output->writeln(number_format($coin->getValue(), 2).' coin returned');
        }

        return Command::SUCCESS;
    }

    /** @throws EntityNotFoundException */
    private function findProduct(string $selector): Product
    {
        /** @var GetProductsResponse $response */
        $response = $this->commandBus->handle(new GetProductsRequest());
        foreach ($response->products as $product) {
            if ($product->getSelector() === $selector) {
                return $product;
            }
        }
        throw new EntityNotFoundException('product not found');
    }
}
