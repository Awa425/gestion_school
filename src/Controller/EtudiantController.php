<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant/list', name: 'app_etudiant')]
    public function index(EtudiantRepository $etRepo, Request $request, PaginatorInterface $paginator): Response
    {
        $etu = $etRepo->findAll();
        $pagination = $paginator->paginate($etu, $request->query->getInt("page", 1), 5);
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
            'etudiant' => $pagination,
        ]);
    }
}
