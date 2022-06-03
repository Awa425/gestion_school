<?php

namespace App\Controller;

use App\Repository\ProfesseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfesseurController extends AbstractController
{
    #[Route('/professeur', name: 'app_professeur')]

    public function index(ProfesseurRepository $repo): Response
    {
        $profs = $repo->findAll();
        return $this->render('professeur/index.html.twig', [
            'title' => 'Liste des professeurs',
            'profs' => $profs
        ]);
    }

    public function workWithOrder()
    {
        // Get the first page of orders
        $paginatedResult = $this->orderRepository->getOrders(1);
        // get the total number of orders
        $totalOrder = count($paginatedResult);

        // Use the Paginator iterator
        foreach ($paginatedResult as $order) {
            $order->doSomething();
        }
    }
}
