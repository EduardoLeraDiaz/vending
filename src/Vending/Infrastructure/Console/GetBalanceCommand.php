<?php

namespace App\Vending\Infrastructure\Console;

use App\Vending\Application\Query\GetBalanceRequest;
use App\Vending\Application\Query\GetBalanceResponse;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'vending:get-balance')]
class GetBalanceCommand extends Command
{
    public function __construct(private CommandBus $commandBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Get the actual balance')
        ->setHelp('This command allows you to get the actual balance');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var GetBalanceResponse $response */
        $response = $this->commandBus->handle(new GetBalanceRequest());
        $output->writeln('balance: ' . number_format($response->balance, 2));
        return Command::SUCCESS;
    }
}
