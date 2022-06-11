<?php

namespace App\Controller;

use App\Entity\Rp;
use App\Form\RpFormType;
use App\Repository\RpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RpController extends AbstractController
{
    #[Route('/rp/list', name: 'app_rp')]
    public function index(Request $request, RpRepository $rpRepo, PaginatorInterface $paginator): Response
    {
        $rp = $rpRepo->findAll();
        $pagination = $paginator->paginate($rp, $request->query->getInt('page', 1), 5);
        return $this->render('rp/index.html.twig', [
            'rp' => $pagination,
        ]);
    }

    #[Route('/rp/add', name: 'add_rp')]
    public function addRp(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $rp = new Rp();
        $form = $this->createForm(RpFormType::class, $rp);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plaintexPass = $rp->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $rp,
                $plaintexPass
            );
            $rp->setPassword($hashedPassword);
            $rp->setRoles(['ROLE_RP']);
            $em->persist($rp);
            $em->flush();
        }
        return $this->render('rp/formRp.html.twig', [
            'formRp' => $form->createView(),
        ]);
    }
}
