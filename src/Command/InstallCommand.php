<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'install',
    description: 'Add a short description for your command',
)]
class InstallCommand extends Command
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->runCommand('doctrine:database:create', [], $output);
        $this->runCommand('doctrine:migrations:migrate', [], $output);

        return Command::SUCCESS;
    }

    /**
     * @param string $commandName
     * @param array $arguments
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function runCommand(string $commandName, array $arguments, OutputInterface $output)
    {
        $command = $this->getApplication()->find($commandName);
        $greetInput = new ArrayInput($arguments);
        $greetInput->setInteractive(false);

        return $command->run($greetInput, $output);
    }
}
