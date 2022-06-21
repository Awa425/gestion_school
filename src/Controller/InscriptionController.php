<?php

namespace App\Controller;

use App\Entity\Ac;
use App\Entity\Etudiant;
use App\Entity\Inscription;
use App\Entity\AnneeScolaire;
use App\Form\EtudiantType;
use App\Form\InscriptionType;
use App\Form\InscritType;
use App\Form\ReinscriptionType;
use App\Repository\AcRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InscriptionRepository;
use App\Repository\AnneeScolaireRepository;
use App\Repository\ClasseRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        $pagination = $paginator->paginate($ins, $request->query->getInt("page", 1), 8);
        return $this->render('inscription/index.html.twig', [
            'title' => 'Liste des inscrits',
            'insrits' => $pagination,
        ]);
    }

    #[Route('/etudiant/inscrire', name: 'inscrire_etudiant')]
    #[Route('/etudiant/{id}/edit', name: 'etudiant_edit')]
    public function inscrire(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, AcRepository $acRepo, AnneeScolaireRepository $anRepo, ClasseRepository $classeRepo, Inscription $ins = null): Response
    {
        if (!$ins) {
            $ins = new Inscription();
        }
        $formEtu = $this->createForm(InscriptionType::class, $ins);
        $formEtu->handleRequest($request);
        if ($formEtu->isSubmitted() && $formEtu->isValid()) {
            $anIns = $anRepo->findOneBy(['etat' => 1]);
            $plaintexPass = "passer";
            $hashedPassword = $passwordHasher->hashPassword(
                $ins->getEtudiant(),
                $plaintexPass
            );
            $ins->getEtudiant()->setPassword($hashedPassword);
            $matri = date('Y\M\A\THisdm');
            $ins->getEtudiant()->setRoles(['ROLE_ETUDIANT']);
            $ins->getEtudiant()->setMatricule($matri);
            $em->persist($ins);
            $ins->setAc($this->getUser());
            $ins->setAnneescolaireId($anIns);
            // dd($ins);
            // $ins->setClasses($classeIns);
            $em->persist($ins);
            $em->flush();
        }
        return $this->render('inscription/inscrire.html.twig', [
            'titre' => 'Liste des inscrit',
            'formEtu' => $formEtu->createView(),
            // "classes" => $classes
        ]);
    }


    #[Route('/etudiant/{id}/reinscrire', name: 'etudiant_reinscrire')]
    public function reinscrire(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, AcRepository $acRepo, AnneeScolaireRepository $anRepo, ClasseRepository $classeRepo, Etudiant $etu): Response
    {
        $ins = new Inscription();
        $ins->setEtudiant($etu);
        $formEtu = $this->createForm(ReinscriptionType::class, $ins);
        $formEtu->handleRequest($request);
        if ($formEtu->isSubmitted() && $formEtu->isValid()) {
            $anIns = $anRepo->findOneBy(['etat' => 1]);
            $plaintexPass = "passer";
            $hashedPassword = $passwordHasher->hashPassword(
                $ins->getEtudiant(),
                $plaintexPass
            );
            $ins->getEtudiant()->setPassword($hashedPassword);
            $matri = date('Y\M\A\THisdm');
            $ins->getEtudiant()->setRoles(['ROLE_ETUDIANT']);
            $ins->getEtudiant()->setMatricule($matri);
            $em->persist($ins);
            $ins->setAc($this->getUser());
            $ins->setAnneescolaireId($anIns);
            // dd($ins);
            // $ins->setClasses($classeIns);
            $em->persist($ins);
            $em->flush();
        }
        return $this->render('inscription/inscrire.html.twig', [
            'titre' => 'Liste des inscrit',
            'formEtu' => $formEtu->createView(),
            // "classes" => $classes
        ]);
    }
}
