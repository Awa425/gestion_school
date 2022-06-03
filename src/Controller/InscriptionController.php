<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(InscriptionRepository $repoIns): Response
    {

        return $this->render('inscription/index.html.twig', [
            'titre' => 'Liste des inscrit',

        ]);
    }
}
