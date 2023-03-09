<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TextField;

class FormController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'homepage')]
    public function homepage(Request $request): Response
    {
        $textField = new TextField();
        $form = $this->createFormBuilder($textField)
            ->add('textField')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $textField = $form->getData();

            $this->entityManager->persist($textField);
            $this->entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        $textFields = $this->entityManager->getRepository(TextField::class)->findAll();


        return $this->render('/homepage.html.twig', [
            'form' => $form->createView(),
            'textField' => $textFields,
        ]);
    }

    #[Route('/update_textfield/{id}', name: 'update_textfield', methods: ['POST'])]
    public function updateTextField(Request $request, int $id): Response
    {
        $text = $request->request->get('text_field');

        $textField = $this->entityManager->getRepository(TextField::class)->find($id);

        $textField->setTextField($text);
        $this->entityManager->flush();

        return $this->redirectToRoute('homepage');
    }
}
