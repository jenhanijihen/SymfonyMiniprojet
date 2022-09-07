<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return Response
     */
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getName();
            if ($nom != "")
                $products = $this->getDoctrine()->getRepository(Product::class)->findBy(['name' => $nom]);

        }
        return $this->render('product/index.html.twig', [
            'form' =>$form->createView(),
            'products' => $products,
        ]);
    }
}
