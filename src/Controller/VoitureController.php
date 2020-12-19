<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\ORM\EntityManagerInterface;

class VoitureController extends AbstractController
{
    /**
     * @Route("/createvoiture", name="create_voiture")
     */
    public function createvoiture(Request $request): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $voiture->setDisponibilite(1);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($voiture);
            $entitymanager->flush();
            
            return $this->redirectToRoute('voiture');
        }

        return $this->render('voiture/ajouter.html.twig', ['form' => $form->createView()]);
        
        //TODO: create a car manually
        // $entitymanager = $this->getDoctrine()->getManager();

        // $voiture->setMatricule('200TU1500');
        // $voiture->setMarque('BMW');
        // $voiture->setDescription('Voiture Luxe');
        // $voiture->setCouleur('Noir');
        // $voiture->setCarburant('Gazoli');
        // $date = new \DateTime('2019-06-05 12:15:38');
        // $voiture->setDatemiseencirculation($date);
        // $voiture->setDisponibilite(1);
        // $voiture->setNbrplace(5);

        // $entitymanager->persist($voiture);
        // $entitymanager->flush();
        // return new Response('Nouvelle voiture ajoutée avec la matricule numéro ',$voiture->get());
    }
    /**
     * @Route("/voiture/{mat}", name="voiturebymat")
     */
    
    public function afficher(String $mat): Response{

        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule' => $mat));

        return $this->render('voiture/ajouter.html.twig', [
            'voitures' =>$voitures,
        ]);
    }
    /**
     * @Route("/modifiervoiture/{mat}", name="editvoiturebymat")
     */
    public function modifier(String $mat):Response 
    {
        $entitymanager = $this->getDoctrine()->getManager();
        $voiture=$this->getDoctrine()->getRepository(voiture::class)->findBy(array('matricule' => $mat));
        if (!$voiture) {
            throw $this->createNotfoundException(
                'Pas de voiture avec la matricule' , $mat
            );
        }


        $voiture[0]->setMarque('POLO');

    $entitymanager->flush();

    return $this->redirectToRoute('voiturebymat', ['mat' => $mat]);

       
    }
}
