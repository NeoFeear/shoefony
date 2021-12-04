<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{
    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_show_product", requirements={"id"="\d+"})
     */
    public function homepage(int $id, string $slug):Response
    {
        return $this->render('store/product.html.twig', [
            'controller_name' => 'StoreController',
            'id' => $id,
            'slug' => $slug,
            'ip' => $_SERVER['REMOTE_ADDR']
        ]);
    }
}