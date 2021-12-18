<?php 

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_homepage", methods={"GET"})
     */
    public function homepage(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
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

        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $this->addFlash('success', 'Merci, votre message a bien été pris en compte !');
            } else {
                $this->addFlash('danger', 'Votre message n\'a pas pu être envoyé, veuillez corriger les erreurs.');
            }
            return $this->redirectToRoute('main_contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}