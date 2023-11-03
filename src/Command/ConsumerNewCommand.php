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
    name: 'consumer-new',
)]
class ConsumerNewCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
            $channel = $connection->channel();

            $channel->queue_declare('task_queue', false, true, false, false);

            $callback = function (AMQPMessage $message) use ($io): void {
                $io->writeln(' [x] Received '. $message->body);
                sleep(strlen($message->body));
                $io->writeln(' [x] Done');
                $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
            };
            $channel->basic_qos(null, 1, null);
            $channel->basic_consume('task_queue', '', false, false, false, false, $callback);
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
