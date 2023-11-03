<?php

namespace App\Command;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'producer-x',
)]
class ProducerXCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
            $channel = $connection->channel();

            $channel->exchange_declare('logs', 'fanout', false, false, false);

            $message = new AMQPMessage('Hello xxx!');
            $channel->basic_publish($message, 'logs');

            $io->writeln(" [x] Sent 'Hello xxx!'");

            $channel->close();
            $connection->close();
        } catch (Exception $e) {
            $io->writeln($e->getMessage());
        }

        return Command::SUCCESS;
    }
}
