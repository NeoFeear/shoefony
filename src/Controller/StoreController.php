<?php

namespace App\Controller;

use App\Entity\Store\Product;
use App\Repository\Store\BrandRepository;
use App\Repository\Store\CommentRepository;
use App\Repository\Store\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{

    public function __construct(
        private ProductRepository $productRepository,
        private BrandRepository $brandRepository,
        private CommentRepository $commentRepository
    )
    {}

    /**
     * @Route("/store/product/list", name="store_list_product", methods={"GET"})
     */
    public function productList(): Response
    {
        $products = $this->productRepository->findAll();

        return $this->render('store/product_list.html.twig', [
            'controller_name' => 'StoreController',
            'products' => $products
        ]);
    }

    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_detail_product", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function productDetail(int $id, string $slug):Response
    {
        $product = $this->productRepository->find($id);
        $comments = $this->commentRepository->findBy(['product' => $product]);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('store/product_detail.html.twig', [
            'controller_name' => 'StoreController',
            'product' => $product,
            'comments' => $comments,
            'slug' => $slug
        ]);
    }
}