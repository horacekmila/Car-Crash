<?php

namespace App\Command;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use App\Service\CarService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DummyCarsCommand extends Command
{
    protected static $defaultName = 'app:dummy-cars';

    private $carRepository;

    private $userRepository;

    private $carService;

    private $em;

    public function __construct(CarRepository $carRepository, CarService $carService, UserRepository $userRepository, EntityManagerInterface $em, string $name = null)
    {
        $this->carRepository = $carRepository;
        $this->userRepository = $userRepository;
        $this->carService = $carService;
        $this->em = $em;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Fills with random data for cars')
            ->addArgument('number', InputArgument::REQUIRED, 'Number of cars');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $root = $this->userRepository->findOneBy(["username" => CreateRootCommand::USER_NAME]);

        for($i = 0; $i <= $input->getArgument('number'); $i++) {
            $car = new Car();
            $car->setLicencePlate($this->carService->generateRandomLicencePlate())
                ->setOwner($root)
                ->setType("personal");
            $this->em->persist($car);
        }

        $this->em->flush();
        return 0;
    }
}
