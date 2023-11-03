<?php

namespace App\Command\Tutorial\Four\Tutorial\Four;

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
    name: 'consumer-x',
)]
class ConsumerXCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
            $channel = $connection->channel();

            $channel->exchange_declare('logs', 'fanout', false, false, false);
            [$queue_name, , ] = $channel->queue_declare('');
            $channel->queue_bind($queue_name, 'logs', $binding_key);

            $callback = function (AMQPMessage $message) use ($io): void {
                $io->writeln(' [x] Received '. $message->body);
                sleep(strlen($message->body));
                $io->writeln(' [x] Done');
                $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
            };
            $channel->basic_consume($queue_name, '', false, true, false, false, $callback);
            while (count($channel->callbacks)) {
                $channel->wait();
            }
            $channel->close();
            $connection->close();
        } catch (\Exception $e) {
            $io->writeln($e->getMessage());
        }
        return Command::SUCCESS;
    }
}
