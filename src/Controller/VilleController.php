<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin", name="admin_")
 */
class VilleController extends AbstractController
{
    /**
     * @Route("/ville/add", name="addVille")
     */
    public function addVille(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $ville = new Ville;
        $form = $this->createForm(VilleFormType::class, $ville);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $ville->setSlug($slugger->slug($ville->getName()));

            $idDepartement = $form['departement']->getData()->getId();

            $em->persist($ville);
            $em->flush();
            
            // $this->addFlash('success', 'Ville ajoutée avec succès');

            return $this->redirectToRoute('index',);
        }

        return $this->render('ville/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Editer les infos d'une ville.
     * @Route("/ville/edit/{id}", name="editVille")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param idVille $id
     * @return Response
     */
    public function editVille(Request $request, EntityManagerInterface $em, $id): Response
    {
        $ville = $em->getRepository(Ville::class)->find($id);

        $form = $this->createForm(VilleFormType::class, $ville);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ville = $form->getData();
            $idDepartement= $form['departement']->getData()->getId();

            $em->persist($ville);
            $em->flush();

            // $this->addFlash('success', 'Ville éditée avec succès');
            return $this->redirectToRoute('admin_departementVille', ['id' => $idDepartement]);
        }

        return $this->render('ville/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Efface une ville
     * @Route("/ville/delete/{id}", name="deleteVille")
     *
     * @param Ville $ville
     * @param EntityManagerInterface $em
     * @param idVille $id
     * @return Response
     */
    public function deleteVille(Ville $ville, EntityManagerInterface $em, $id): Response
    {
        $idDepartement= $ville->getDepartement()->getId();
        // dd($idCategory);
        $em->remove($ville);
        $em->flush();

        // $this->addFlash('success', 'Ville effacée avec succès');

        return $this->redirectToRoute('admin_departementVille', ['id' => $idDepartement]);
    }
}
