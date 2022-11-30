<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index')]
    public function index(Request $request,PaginatorInterface $paginator,EvenementRepository $evenementRepository)
    {
        $evenements= $evenementRepository->findAll();
        return $this->render('evenement/index.html.twig', array(
            'evenements' => $evenements
        ));
    }

    #[Route('/new', name: 'app_evenement_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry, EvenementRepository $evenementRepository)
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('app_evenement_index');
        }
        return $this->renderForm('evenement/add.html.twig',array(
            'evenement' => $evenement,
            'form' => $form
        ));
    }

    #[Route('/{id}', name: 'app_evenement_delete')]
    public function deleteevent ($id,EvenementRepository $repository,ManagerRegistry $managerRegistry)
    {
        $classroom = $repository->find($id);
        $repository->remove($classroom);
        $em = $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("app_evenement_index");
    }

    #[Route('/detailEve/{id}', name: 'app_evenement2_detail')]
    public function detailtypeevenement($id,EvenementRepository $Repository)
    {
        return $this->render('evenement/show.html.twig',array(
            'i' => $Repository->find($id)
        ));
    }

    #[Route('/updateEvenement/{id}', name: 'update_evenement')]
    public function updateclassroom($id,Request $request,  EvenementRepository $repository,ManagerRegistry $managerRegistry)
    {
        $evenement = $repository->find($id);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute('app_evenement_index');
        }
        return $this->renderForm('evenement/update.html.twig',array(
            'evenement' => $evenement,
            'form' => $form
        ));
    }



}