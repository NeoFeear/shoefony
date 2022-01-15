<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{
    /**
     * @Route("/store/product/list", name="store_list_product", methods={"GET"})
     */
    public function productList(): Response
    {
        return $this->render('store/product_list.html.twig', [
            'controller_name' => 'StoreController'
        ]);
    }

    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_detail_product", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function productDetail(int $id, string $slug):Response
    {
        return $this->render('store/product_detail.html.twig', [
            'controller_name' => 'StoreController',
            'id' => $id,
            'slug' => $slug
        ]);
    }
}