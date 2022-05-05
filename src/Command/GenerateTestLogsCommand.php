<?php

namespace App\Command;

use App\Service\TestLogFileGenerateService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'generate:logs',
    description: 'Generate test logs',
)]
class GenerateTestLogsCommand extends Command
{
    /**
     * @var string|null
     */
    protected string $logsPath;

    /**
     * @param string|null $path
     */
    public function __construct(string $path = null)
    {
        parent::__construct($path);

        $this->logsPath = $path;
    }

    protected function configure(): void
    {
        $this->addArgument('records-count', InputArgument::OPTIONAL, 'Argument description');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $recordsCount = $input->getArgument('records-count') ?? 1000;

        $generationService = new TestLogFileGenerateService($this->logsPath);

        $logsFilesList = ['test1.log', 'test2.log'];
        foreach ($logsFilesList as $logsFileName) {
            $generationService->generateLogFile($this->logsPath . '/' . $logsFileName, $recordsCount);

        }
        $io->success('Logs ' . implode(', ', $logsFilesList) . ' successfully generated.');

        return Command::SUCCESS;
    }
}
