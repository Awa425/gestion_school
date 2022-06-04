<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Form\ProfType;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfesseurController extends AbstractController
{
    #[Route('/professeur', name: 'app_professeur')]

    public function index(ProfesseurRepository $repo, Request $request, PaginatorInterface $paginator): Response
    {
        $profs = $repo->findAll();
        $pagination = $paginator->paginate($profs, $request->query->getInt("page", 1), 5);
        return $this->render('professeur/index.html.twig', [
            'title' => 'Liste des professeurs',
            'profs' => $pagination
        ]);
    }

    #[Route('/add-prof', name: 'add_professeur')]
    public function addProf(Request $request, EntityManagerInterface $em): Response
    {
        $prof = new Professeur();
        $form = $this->createForm(ProfType::class, $prof);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($prof);
            $em->flush();
        }

        return $this->render('professeur/formProf.html.twig', [
            'title' => 'Liste des professeurs',
            'FormProf' => $form->createView()
        ]);
    }
}
