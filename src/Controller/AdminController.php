<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $cars = $this->getDoctrine()->getManager()->getRepository(Car::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'cars' => $cars,
        ]);
    }
}
