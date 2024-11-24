<?php

namespace App\Vending\Infrastructure\Console;

use App\Vending\Application\Command\SetProductsRequest;
use App\Vending\Application\Query\GetProductsRequest;
use App\Vending\Application\Query\GetProductsResponse;
use App\Vending\Domain\Entity\Product;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(name: 'vending:service')]
class ServiceCommand extends Command
{
    private const VALUE_PARAMETER_NAME = 'products';

    public function __construct(
        private CommandBus $commandBus,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this->setDescription('Service for setting the amount of products.')
            ->setHelp('This command allow to set the type and amount of products. \\n It takes a json as a argument like that: \'{"products":[{"name":"name","selector":"the selector as unique value","stock": 100}]}\'')
            ->addArgument(self::VALUE_PARAMETER_NAME, InputArgument::REQUIRED, 'The JSON string representing a collection of products.');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $value = $input->getArgument(self::VALUE_PARAMETER_NAME);

        try {
            /** @var ServiceCommandPayload $payload */
            $payload = $this->serializer->deserialize($value, ServiceCommandPayload::class, 'json');
            $errors = $this->validator->validate($payload);

            if (count($errors) > 0) {
                throw new ValidationFailedException("(string) $errors", $errors);
            }
        } catch(\Exception $e) {
            $output->writeln(sprintf('Invalid products parameter: %s', $e->getMessage()));
            return Command::SUCCESS;
        }

        $this->commandBus->handle(new SetProductsRequest($payload->products));

        /** @var GetProductsResponse $response */
        $response = $this->commandBus->handle(new GetProductsRequest());
        $stringProducts = json_encode($response->products, JSON_PRETTY_PRINT);
        $output->writeln($stringProducts);

        return Command::SUCCESS;
    }
}
