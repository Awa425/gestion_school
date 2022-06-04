<?php

namespace App\Controller;

use App\Entity\Module;
use App\Repository\ModuleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(ModuleRepository $modRepo, Request $request, PaginatorInterface $paginator): Response
    {
        $momodules = $modRepo->findAll();
        $pagination = $paginator->paginate($momodules, $request->query->getInt("page", 1), 5);
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
            'modules' => $pagination,
        ]);
    }

    #[Route('/add-module', name: 'add_module')]
    public function addModule(Request $request, ModuleRepository $modRepo): Response
    {
        if ($request->isMethod('GET')) {
            $addModule = new Module();
            $form = $this->createFormBuilder($addModule)
                ->add('libelle', TextType::class)
                ->add('Ajouter', SubmitType::class)
                ->getForm();
            return $this->render('module/moduleForm.html.twig', [
                'Form' => $form->createView(),

            ]);
        }
        if ($request->isMethod('POST')) {
            extract($_POST);
            $module = new Module();
            $module->setLibelle($form['libelle']);
            $modRepo->add($module, true);
            return $this->redirectToRoute("app_module");
        }
    }
}
