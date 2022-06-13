<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ClasseController extends AbstractController
{
    #[Route('/classe-liste', name: 'app_classe')]
    public function index(ClasseRepository $classeRepo, Request $request, PaginatorInterface $paginator): Response
    {
        $classes = $classeRepo->findAll();
        $pagination = $paginator->paginate($classes, $request->query->getInt("page", 1), 5);
        return $this->render('classe/index.html.twig', [
            'controller_name' => 'ClasseController',
            'classes' => $pagination,
        ]);
    }

    #[Route('/classe/add', name: 'add_classe')]
    #[Route('/classe/{id}/edit', name: 'classe_edit')]
    public function addClasse(Classe $classe = null, Request $request, EntityManagerInterface $em): Response
    {
        if (!$classe) {
            $classe = new Classe();
        }
        $form = $this->createFormBuilder($classe)
            ->add('libelle')
            ->add('niveau')
            ->add('filliere')
            ->add('Ajouter', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($classe);
            $em->flush();
            $this->redirectToRoute('app_classe');
        }
        return $this->render('classe/add.html.twig', [
            'controller_name' => 'ClasseController',
            'formClasse' => $form->createView()
        ]);
    }
}
