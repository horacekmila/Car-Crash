<?php

namespace App\Command;

use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateRootCommand extends Command
{
    protected static $defaultName = 'app:create-root';

    const USER_NAME = "root";

    private $userService;

    public function __construct(UserService $userService, string $name = null)
    {
        parent::__construct($name);
        $this->userService = $userService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates root')
            ->addArgument('Password', InputArgument::REQUIRED, 'ROOTS password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->userService->createUser(self::USER_NAME, $input->getArgument('Password'), true);
        return 0;
    }
}
