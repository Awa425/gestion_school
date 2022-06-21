<?php

namespace App\Controller;

use App\Repository\AnneeScolaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function mySession(Request $request, AnneeScolaireRepository $anRepo): Response
    {
        $anIns = $anRepo->findOneBy(['etat' => 1]);

        $session = $request->getSession();
        $session->set('date', $anIns);

        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }
}
