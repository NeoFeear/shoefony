<?php

namespace App\Controller;

use App\Entity\Store\Comment;
use App\Entity\Store\Product;
use App\Form\CommentType;
use App\Repository\Store\BrandRepository;
use App\Repository\Store\CommentRepository;
use App\Repository\Store\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoreController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private ProductRepository $productRepository,
        private BrandRepository $brandRepository,
        private CommentRepository $commentRepository
    )
    {}

    /**
     * @Route("/store/product/list", name="store_list_products", methods={"GET"})
     * @Route("/store/product/list/{brandId}", name="store_list_products_by_brand", methods={"GET"})
     */
    public function productList(?int $brandId): Response
    {
        if ($brandId) {
            $brand = $this->brandRepository->find($brandId);
            if ($brand === null) {
                throw new NotFoundHttpException('Brand not found');
            } else {
                $products = $this->productRepository->findByBrand($brandId);
            }
        } else {
            $products = $this->productRepository->findAllWithDetails();
        }

        return $this->render('store/product_list.html.twig', [
            'products' => $products,
            'brand' => $brand ?? null,
            'brandId' => $brandId,
        ]);
    }

    /**
     * @Route("/store/product/{id}/details/{slug}", name="store_detail_product", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function productDetail(int $id, string $slug, Request $request): Response
    {
        $product = $this->productRepository->findOneWithDetails($id);
        $comments = $this->commentRepository->findBy(['product' => $product]);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $comment = new Comment();
        $comment->setProduct($product);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre commentaire a bien été envoyé');

            $this->em->persist($comment);
            $this->em->flush();

            return $this->redirectToRoute('store_detail_product', [
                'id' => $product->getId(),
                'slug' => $product->getSlug(),
            ]);
        }

        return $this->render('store/product_detail.html.twig', [
            'product' => $product,
            'comments' => $comments,
            'slug' => $slug,
            'form' => $form->createView(),
        ]);
    }

    public function listBrands(?int $brandId): Response
    {
        return $this->render('store/_list_brands.html.twig', [
            'brands' => $this->brandRepository->findAll(),
            'brandId' => $brandId,
        ]);
    }

    public function cardProduct(string $productType): Response
    {
        return $this->render('store/_card_product.html.twig', [
            'productType' => $productType,
        ]);
    }
}