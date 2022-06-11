<?php

namespace App\Controller;

use App\Entity\Ac;
use App\Entity\Etudiant;
use App\Entity\Inscription;
use App\Entity\AnneeScolaire;
use App\Form\InscriptionType;
use App\Repository\AcRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InscriptionRepository;
use App\Repository\AnneeScolaireRepository;
use App\Repository\ClasseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(InscriptionRepository $repoIns): Response
    {
        return $this->render('inscription/index.html.twig', [
            'titre' => 'Liste des inscrit',
        ]);
    }

    #[Route('/inscrire', name: 'inscrire_etudiant')]
    public function inscrire(Request $request, EntityManagerInterface $em, AcRepository $acRepo, AnneeScolaireRepository $anRepo, ClasseRepository $classeRepo): Response
    {
        $etu = new Etudiant();

        $acs = $acRepo->findAll();
        $classes = $classeRepo->findAll();
        $anSc = $anRepo->findAll();

        $formEtu = $this->createFormBuilder($etu)
            ->add('nomComplet')
            ->add('email')
            ->add('password')
            ->add('adresse')
            ->add('sexe')
            ->add('matricule')
            ->getForm();

        $formEtu->handleRequest($request);
        $ins = new Inscription();
        if ($formEtu->isSubmitted() && $formEtu->isValid()) {
            $acIns = $acRepo->find($request->get('ac'));
            $anIns = $anRepo->find($request->get('anneescolaire_id'));
            $classeIns = $classeRepo->find($request->get('clases'));
            // dd($anIns);
            $em->persist($etu);
            $ins->setAc($acIns);
            $ins->setAnneescolaireId($anIns);
            $ins->setClasses($classeIns);
            $ins->setEtudiant($etu);
            $em->persist($ins);
            $em->flush();
        }
        return $this->render('inscription/inscrire.html.twig', [
            'titre' => 'Liste des inscrit',
            'formEtu' => $formEtu->createView(),
            "acs" => $acs,
            "anSc" => $anSc,
            "classes" => $classes
        ]);
    }
}
