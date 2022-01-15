<?php

namespace App\Controller;

use App\Entity\Store\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/store/product/list", name="store_list_product", methods={"GET"})
     */
    public function productList(): Response
    {
        $products = $this->em->getRepository(Product::class)->findAll();

        return $this->render('store/product_list.html.twig', [
            'controller_name' => 'StoreController',
            'products' => $products,
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