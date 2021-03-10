<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Model\User\UseCase\Create;
use App\ReadModel\User\UserFetcher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateCommand extends Command
{
    public function __construct(
        private UserFetcher $users,
        private Create\Manual\Handler $handler,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('user:create')
            ->setDescription('Creates user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $email = $helper->ask($input, $output, new Question('Email: '));
        $password = $helper->ask($input, $output, new Question('Password: '));
        $repeatPassword = $helper->ask($input, $output, new Question('Repeat password: '));

        if ($user = $this->users->findByEmail($email)) {
            throw new LogicException('User already have.');
        }

        if ($password !== $repeatPassword) {
            throw new LogicException('Password mismatch.');
        }

        $command = new Create\Manual\Command($email, $password);
        $this->handler->handle($command);

        $output->writeln('<info>Done!</info>');

        return 1;
    }
}
