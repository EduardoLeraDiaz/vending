<?php

namespace App\Vending\Infrastructure\Console;

use App\Vending\Application\Command\AlterPurseRequest;
use App\Vending\Application\Command\ResetBalanceRequest;
use App\Vending\Application\Query\CalculateCoinsForAmountRequest;
use App\Vending\Application\Query\CalculateCoinsForAmountResponse;
use App\Vending\Application\Query\GetBalanceRequest;
use App\Vending\Application\Query\GetBalanceResponse;
use App\Vending\Domain\Service\CalculateCoinsService;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'vending:return-money')]
class ReturnMoneyCommand extends Command
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Return coins for the actual balance')
            ->setHelp('This command return coins for the balance using the less amount of coins possible and set the balance to zero');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var GetBalanceResponse $getBalanceResponse */
        $getBalanceResponse = $this->commandBus->handle(new GetBalanceRequest());

        /** @var CalculateCoinsForAmountResponse $coinsResponse */
        $coinsResponse = $this->commandBus->handle(new CalculateCoinsForAmountRequest($getBalanceResponse->balance));

        $this->commandBus->handle(AlterPurseRequest::fromCoins($coinsResponse->coins));
        $this->commandBus->handle(new ResetBalanceRequest());

        foreach ($coinsResponse->coins as $coin) {
            $output->writeln(number_format($coin->getValue(), 2).' coin returned');
        }
        return Command::SUCCESS;
    }
}
