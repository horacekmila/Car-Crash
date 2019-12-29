<?php


namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $repository;

    private $entityManager;

    private $encoder;

    public function __construct(UserRepository $repository, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    public function createUser(string $username, string $plainPassword): User
    {
        $user = new User();
        $user->setUsername($username);
        $password = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}