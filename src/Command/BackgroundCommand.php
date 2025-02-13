<?php

namespace App\Command;

use DateTime;
use App\Services\RemunerationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'BackgroundCommand',
    description: 'Add a short description for your command',
)]
class BackgroundCommand extends Command
{
    public function __construct(
        private RemunerationService $remunerationService
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
      
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dateOfThePreviousMonthToCheck = (new DateTime())->modify('-1 hour');
        $this->remunerationService->checkUserRemuneration($dateOfThePreviousMonthToCheck);
        $output->writeln('Success');

        return Command::SUCCESS;
    }
}
