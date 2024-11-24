<?php

namespace App\Vending\Infrastructure\Console;

use App\Vending\Application\Command\InsertMoneyRequest;
use App\Vending\Domain\ValueObject\Coin;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'vending:insert-money')]
class InsertMoneyCommand extends Command
{
    private const VALUE_PARAMETER_NAME = 'value';

    public function __construct(private CommandBus $commandBus)
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this->setDescription('Insert a coin on the machine.')
            ->setHelp('This command insert a coin on the machine. Use it as insert-money and the value, example insert-money 0.10')
            ->addArgument(self::VALUE_PARAMETER_NAME, InputArgument::REQUIRED, 'The value of the coin.');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $value = $input->getArgument(self::VALUE_PARAMETER_NAME);

        try {
            $cents = intval(floatval($value)*100);
            $coin = new Coin($cents);
        } catch(\Exception $exception) {
            $output->writeln($value. ' coin returned');
            return Command::SUCCESS;
        }

        $this->commandBus->handle(new InsertMoneyRequest($coin));
        $output->writeln(number_format($coin->getValue(),2).' coin inserted');
        return Command::SUCCESS;
    }
}
