<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Crash;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/cars/view/{id}", name="car_detail")
     */
    public function index(Car $id)
    {
        $crashes = $this->em->getRepository(Crash::class)->findBy(["car" => $id]);

        return $this->render('car/index.html.twig', [
            'car' => $id,
            'crashes' => $crashes
        ]);
    }

    /**
     * @Route("/cars/delete/{id}", name="car_delete")
     */
    public function delete(Car $id)
    {
        $this->em->remove($id);
        $this->em->flush();
        return $this->redirectToRoute("app_homepage");
    }

    /**
     * @Route("/cars/add", name="car_add")
     */
    public function add(Request $request)
    {
        $car = new Car();
        $car->setOwner($this->getUser());

        $form = $this->createFormBuilder($car)
            ->add('licencePlate', TextType::class, ["label" => "SPZ"])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    "Osobní" => Car::PERSONAL,
                    "Profesionální" => Car::PROFESIONAL
                ],
            ])
            ->add('submit', SubmitType::class, ['label' => 'Uložit'])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isSubmitted()) {
            $this->em->persist($car);
            $this->em->flush();
            return $this->redirectToRoute("app_homepage");
        }

        return $this->render('car/add.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
