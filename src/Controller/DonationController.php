<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Entity\Evenement;
use App\Form\DonationType;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\SponsorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/donation')]
class DonationController extends AbstractController
{
    #[Route('/donation', name: 'app_donation')]
    public function index(): Response
    {
        return $this->render('donation/index.html.twig', [
            'controller_name' => 'DonationController',
        ]);
    }

    #[Route('/{id}', name: 'app_donation')]
    public function add (PaginatorInterface $paginator,$id,MailerInterface $mailer,SponsorRepository $sponsorRepository,EvenementRepository $evenementRepository,Request $request,ManagerRegistry $managerRegistry)
    {
        $evenements= $evenementRepository->findAll();
        $pagination = $paginator->paginate(
            $evenements,
            $request->query->getInt('page', 1),
            3
        );
        $event = $evenementRepository->find($id);

        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $montant = (int)$request->request->get('donation')['montants'];
            $event->setMontantRecole($evenementRepository->getDon($id)+$montant);
            $donation->setCreatedAt(new \DateTimeImmutable());
            $donation->setListeevents($event);
            $em = $managerRegistry->getManager();
            $em->persist($donation);
            $em->flush();

            //mail
            $sponsor_id = (int)$request->request->get('donation')['listesponsors'];
            $sponsor = $sponsorRepository->find($sponsor_id);
            $email = (new Email())
                ->from('iclinique10@gmail.com')
                ->to($sponsor->getEmailSociete())
                ->subject('Confirmation')
                ->html('iClinique family wanna thank the '.$sponsor->getNomSociete().' corporate for helping people in need!');
            $mailer->send($email);
            return $this->redirectToRoute('app_front_eve');
        }
        return $this->renderForm('front-office/adddon.html.twig',array(
            'form' => $form,
            'evenements'=> $pagination,
            'event'=>$event
        ));
    }
}
