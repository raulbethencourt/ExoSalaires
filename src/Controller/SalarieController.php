<?php

namespace App\Controller;

use App\Entity\Salarie;
use App\Form\SalarieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/add", name="salarie_add")
     * @Route("/{id}/edit", name="salarie_edit")
     * @param Salarie|null $salarie
     * @param Request $request
     * @return Response
     */
    public function addSalarie(Salarie $salarie = null, Request $request): Response
    {
        if (!$salarie)
        {
            $salarie = new Salarie();
        }

        $form = $this->createForm(SalarieType::class, $salarie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($salarie);
            $this->em->flush();
            $this->addFlash('success', 'Bien crée avec succès');

            return $this->redirectToRoute('salaries_index');
        }

        return  $this->render('salarie/add_edit.html.twig', array(
            'form' => $form->createView(),
            'editMode' => $salarie->getId() !== null,
        ));
    }

    /**
     * @Route("/{id}/delete", name="salarie_delete")
     * @param Salarie $salarie
     * @return RedirectResponse
     */
    public function delete(Salarie $salarie)
    {
        $this->em->remove($salarie);
        $this->em->flush();
        $this->addFlash('success', 'Bien supprimé avec succès');
        return $this->redirectToRoute('salaries_index');
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
