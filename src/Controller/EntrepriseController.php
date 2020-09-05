<?php

namespace App\Controller;

use App\Entity\Entreprise;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EntrepriseController
 * @package App\Controller
 * @Route ("/entreprises")
 */
class EntrepriseController extends AbstractController
{
    /**
     * @Route("/", name="entreprise_index")
     */
    public function index()
    {
        $entreprises = $this->getDoctrine()
            ->getRepository(Entreprise::class)
            ->getAll();

        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    /**
     * @Route ("/{id}", name="entreprise_show", methods="GET")
     */
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', ['entreprise' => $entreprise]);
    }
}
