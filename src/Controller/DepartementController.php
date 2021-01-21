<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementFormType;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 */
class DepartementController extends AbstractController
{
    /**
     * Liste des départements
     * @Route("/departement", name="departementList")
     */
    public function index(DepartementRepository $departementRepository): Response
    {
        $listeDepartement = $departementRepository->findAll();

        return $this->render('departement/departementList.html.twig', [
            'listeDepartement' => $listeDepartement,
        ]);
    }

    /**
     * @Route("/departementVille/{id}", name="departementVille")
     */
    public function villeByDepartement(VilleRepository $villeRepository, $id): Response
    {
        $departement = $this->getDoctrine()->getRepository(Departement::class)->find($id);
        $listeVilles = $villeRepository->findBy(['departement' => $departement]);
        
        return $this->render('departement/departementVilles.html.twig', [
            'listeVilles' => $listeVilles
        ]);
    }

    /**
     * @Route("/departement/add", name= "addDepartement")
     *
     * @return void
     */
    public function addDepartement(Request $request, EntityManagerInterface $em){
       
        $departement = new Departement;
        $form= $this->createForm(DepartementFormType::class, $departement);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($departement);
            $em->flush();

            // $this->addFlash('success', 'Catégorie ajoutée avec succès');

            return $this->redirectToRoute('admin_departementList');
        }

        return $this->render('departement/add.html.twig', ['form' => $form->createView()]);
    }

     /**
     * @Route("/departement/edit/{id}", name= "editDepartement")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param idDepartement $id
     * @return void
     */
    public function editDepartement(Request $request, EntityManagerInterface $em, $id){

        $departement = $em->getRepository(Departement::class)->find($id);
        $form= $this->createForm(DepartementFormType::class, $departement);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($departement);
            $em->flush();

            // $this->addFlash('success', 'Département modifié avec succès');

            return $this->redirectToRoute('admin_departementList');
        }

        return $this->render('departement/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/departement/delete/{id}", name = "deleteDepartement")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param id $id
     */
    public function deleteDepartement(Departement $departement, EntityManagerInterface $em, $id)
    {
        $em->remove($departement);
        $em->flush();

        // $this->addFlash('success', 'Département suppprimé avec succès');

        return $this->redirectToRoute('admin_departementList', []);
    }
}
