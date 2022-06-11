<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleFormType;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    #[Route('/module/list', name: 'app_module')]
    public function index(ModuleRepository $modRepo, Request $request, PaginatorInterface $paginator): Response
    {
        $momodules = $modRepo->findAll();
        $pagination = $paginator->paginate($momodules, $request->query->getInt("page", 1), 5);
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
            'modules' => $pagination,
        ]);
    }

    #[Route('/module/add', name: 'add_module')]
    public function addModule(Request $request, EntityManagerInterface $em): Response
    {

        $module = new Module();

        $form = $this->createForm(ModuleFormType::class, $module);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($module);

            $em->flush();
        }

        return $this->render('module/moduleForm.html.twig', [
            'Form' => $form->createView(),
        ]);
    }
}
