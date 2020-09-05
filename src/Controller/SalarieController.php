<?php

namespace App\Controller;

use App\Entity\Salarie;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SalarieController
 * @package App\Controller
 * @Route ("/salaries")
 */
class SalarieController extends AbstractController
{

    public function addSalarie(Salarie $salarie = null, Request $request, ObjectManager $manager)
    {
        if (!$salarie)
        {
            $salarie = new Salarie();
        }


    }

    /**
     * @Route("/", name="salaries_index")
     */
    public function index()
    {
        $salaries = $this->getDoctrine()
            ->getRepository(Salarie::class)
            ->getAll();

        return $this->render('salarie/index.html.twig', [
            'salaries' => $salaries,
        ]);
    }

    /**
     * @Route ("/{id}", name="salarie_show", methods="GET")
     */
    public function show(Salarie $salarie): Response
    {
        return $this->render('salarie/show.html.twig', ['salarie' => $salarie]);
    }
}
