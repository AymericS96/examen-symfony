<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Affiche la liste des villes
     * @Route("/", name="index")
     */
    public function index(VilleRepository $repo): Response
    {
        $villes= $repo->findAll();

        return $this->render('index.html.twig', [ 'villes' => $villes ]);
    }

    /**
     * Affiche le détail d'une ville
     * @Route("/ville/{id}-{slug}", name="detailVille")
     *
     * @param Ville $ville
     * @return Response
     */
    public function detailVille(Ville $ville): Response
    {
        $departementVille= $ville->getDepartement()->getName();
        // dd($departementVille);
        return $this->render('ville/show.html.twig', 
        ['ville' => $ville, 'departementVille' => $departementVille]);
    }
}
