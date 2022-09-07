<?php

namespace App\Controller;

use App\Entity\Panic;
use App\Form\PanicType;
use App\Repository\PanicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/panic")
 */
class PanicController extends AbstractController
{
    /**
     * @Route("/", name="panic_index", methods={"GET"})
     */
    public function index(PanicRepository $panicRepository): Response
    {
        return $this->render('panic/index.html.twig', [
            'panics' => $panicRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="panic_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $panic = new Panic();
        $form = $this->createForm(PanicType::class, $panic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($panic);
            $entityManager->flush();

            return $this->redirectToRoute('panic_index');
        }

        return $this->render('panic/new.html.twig', [
            'panic' => $panic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="panic_show", methods={"GET"})
     */
    public function show(Panic $panic): Response
    {
        return $this->render('panic/show.html.twig', [
            'panic' => $panic,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="panic_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Panic $panic): Response
    {
        $form = $this->createForm(PanicType::class, $panic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('panic_index');
        }

        return $this->render('panic/edit.html.twig', [
            'panic' => $panic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="panic_delete", methods={"POST"})
     */
    public function delete(Request $request, Panic $panic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panic->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($panic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('panic_index');
    }
}
