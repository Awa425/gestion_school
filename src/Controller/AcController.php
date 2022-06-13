<?php

namespace App\Controller;

use App\Entity\Ac;
use App\Form\AcType;
use App\Repository\AcRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AcController extends AbstractController
{
    #[Route('/ac/list', name: 'app_ac')]
    public function index(Request $request, AcRepository $acRepo, PaginatorInterface $paginator): Response
    {
        $ac = $acRepo->findAll();
        $pagination = $paginator->paginate($ac, $request->query->getInt('page', 1), 5);
        return $this->render('ac/index.html.twig', [
            'ac' => $pagination,
        ]);
    }

    #[Route('/ac/add', name: 'add_ac')]
    #[Route('/ac/{id}/edit', name: 'ac_edit')]
    public function addAc(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, Ac $ac = null): Response
    {
        if (!$ac) {
            $ac = new Ac();
        }
        $form = $this->createForm(AcType::class, $ac);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($request);
            $plaintexPass = $ac->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $ac,
                $plaintexPass
            );
            $ac->setPassword($hashedPassword);
            $ac->setRoles(['ROLE_AC']);
            $em->persist($ac);
            $em->flush();
        }
        return $this->render('ac/formAc.html.twig', [
            'formAc' => $form->createView(),
        ]);
    }
}
