<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Crash;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrashController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/crash/add/{car_id}", name="crash_add")
     * @param Car $car_id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function add(Car $car_id, Request $request)
    {
        $crash = new Crash();
        $crash->setCar($car_id);

        $form = $this->createFormBuilder($crash)
            ->add('accidentAt', DateType::class)
            ->add('fine', IntegerType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isSubmitted()) {
            $this->em->persist($crash);
            $this->em->flush();
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('crash/add.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
