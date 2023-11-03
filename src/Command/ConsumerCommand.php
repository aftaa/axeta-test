<?php

namespace App\Command;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'consumer',
)]
class ConsumerCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
            $channel = $connection->channel();
            $channel->queue_declare('hello', false, false, false, false);
            $callback = function (AMQPMessage $message) use ($io): void {
                $io->writeln(' [x] Received '. $message->body);
            };
            $channel->basic_consume('hello', '', false, true, false, false, $callback);
            while (count($channel->callbacks)) {
                $channel->wait();
            }
            $channel->close();
            $connection->close();
        } catch (\Exception $e) {
        }
        return Command::SUCCESS;
    }
}
