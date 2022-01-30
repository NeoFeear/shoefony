<?php 

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Store\Product;
use App\Form\ContactType;
use App\Mailer\ContactMailer;
use App\Repository\Store\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private ContactMailer $mailer,
        private ProductRepository $productRepository,
    ) {
        
    }

    /**
     * @Route("/", name="main_homepage", methods={"GET"})
     */
    public function homepage(): Response
    {
        $lastProducts = $this->productRepository->findLastProducts(4);
        $mostCommentedProducts = $this->productRepository->findMostCommentedProducts(4);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'last_products' => $lastProducts,
            'most_commented_products' => $mostCommentedProducts,
        ]);
    }

    /**
     * @Route("/presentation", name="main_presentation", methods={"GET"})
     */
    public function presentation():Response
    {
        return $this->render('main/presentation.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/contact", name="main_contact", methods={"GET", "POST"})
     */
    public function contact(Request $request):Response
    {
        $contact = new Contact();
        
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($contact);
            $this->em->flush();

            $this->addFlash('success', 'Merci, votre message a bien été pris en compte !');
            $this->mailer->sendMail($contact);
            return $this->redirectToRoute('main_contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}