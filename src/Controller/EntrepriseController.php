<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/add", name="entreprise_add")
     * @Route("/{id}/edit", name="entreprise_edit")
     * @param Entreprise|null $entreprise
     * @param Request $request
     * @return Response
     */
    public function addEntreprise(Entreprise $entreprise = null, Request $request): Response
    {
        if (!$entreprise)
        {
            $entreprise = new Entreprise();
        }

        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($entreprise);
            $this->em->flush();
            $this->addFlash('success', 'Bien crée avec succès');

            return $this->redirectToRoute('entreprise_index');
        }

        return  $this->render('entreprise/add_edit.html.twig', array(
            'form' => $form->createView(),
            'editMode' => $entreprise->getId() !== null,
        ));
    }

    /**
     * @Route("/{id}/delete", name="entreprise_delete")
     * @param Entreprise $entreprise
     * @return RedirectResponse
     */
    public function delete(Entreprise $entreprise)
    {
        $this->em->remove($entreprise);
        $this->em->flush();
        $this->addFlash('success', 'Bien supprimé avec succès');
        return $this->redirectToRoute('entreprise_index');
    }

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
