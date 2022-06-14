<?php

namespace App\Controller;

use App\Entity\Ac;
use App\Entity\Etudiant;
use App\Entity\Inscription;
use App\Entity\AnneeScolaire;
use App\Form\EtudiantType;
use App\Form\InscriptionType;
use App\Repository\AcRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InscriptionRepository;
use App\Repository\AnneeScolaireRepository;
use App\Repository\ClasseRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{
    #[Route('/etudiant/list', name: 'app_etudiant')]
    public function index(InscriptionRepository $insRepo, Request $request, PaginatorInterface $paginator): Response
    {
        $ins = $insRepo->findAll();
        // dd($ins);
        $pagination = $paginator->paginate($ins, $request->query->getInt("page", 1), 8);
        return $this->render('inscription/index.html.twig', [
            'title' => 'Liste des inscrits',
            'insrits' => $pagination,
        ]);
    }

    #[Route('/etudiant/inscrire', name: 'inscrire_etudiant')]
    #[Route('/etudiant/{id}/edit', name: 'etudiant_edit')]
    public function inscrire(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, AcRepository $acRepo, AnneeScolaireRepository $anRepo, ClasseRepository $classeRepo, Etudiant $etu = null): Response
    {
        if (!$etu) {
            $etu = new Etudiant();
        }
        //C'est pour les afficher a la vue
        $classes = $classeRepo->findAll();
        $formEtu = $this->createForm(EtudiantType::class, $etu);

        // $formEtu = $this->createFormBuilder($etu)
        //     ->add('nomComplet')
        //     ->add('email')
        //     ->add('password')
        //     ->add('adresse')
        //     ->add('sexe', ChoiceType::class, [
        //         'choices' => [
        //             'masculin' => 1,
        //             'Feminin' => 0
        //         ],

        //     ])
        //     ->add('matricule')
        //     ->getForm();

        $formEtu->handleRequest($request);
        $ins = new Inscription();
        if ($formEtu->isSubmitted() && $formEtu->isValid()) {
            $anIns = $anRepo->findOneBy(['etat' => 1]);
            $classeIns = $classeRepo->find($request->get('clases'));
            $plaintexPass = $etu->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $etu,
                $plaintexPass
            );
            $etu->setPassword($hashedPassword);
            $etu->setRoles(['ROLE_ETUDIANT']);
            $em->persist($etu);
            $ins->setAc($this->getUser());
            $ins->setAnneescolaireId($anIns);
            $ins->setClasses($classeIns);
            $ins->setEtudiant($etu);
            $em->persist($ins);
            $em->flush();
        }
        return $this->render('inscription/inscrire.html.twig', [
            'titre' => 'Liste des inscrit',
            'formEtu' => $formEtu->createView(),
            "classes" => $classes
        ]);
    }
}
