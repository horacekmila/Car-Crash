<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index()
    {
        $cars = $this->getDoctrine()->getManager()->getRepository(Car::class)->findBy(["owner" => $this->getUser()]);
        return $this->render('homepage/index.html.twig', [
            "cars" => $cars
        ]);
    }
}

