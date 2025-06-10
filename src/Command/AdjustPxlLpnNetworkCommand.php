<?php

namespace App\Command;

use App\Services\AuthService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'AdjustPxlLpnNetwork',
    description: 'Redesign Lpn network based on pixelForce network',
)]
class AdjustPxlLpnNetworkCommand extends Command
{
     public function __construct(
        private AuthService $authService
    )
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'The username')
            ->addArgument('password', InputArgument::REQUIRED, 'The password');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        try {
            $this->authService->redesignLpnNetworkBasedOnPixelForceNetwork([
                'username' => $username,
                'password' => $password,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
       
        $io->success('Success');

        return Command::SUCCESS;
    }
}
