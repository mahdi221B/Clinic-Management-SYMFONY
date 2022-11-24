<?php

namespace App\Controller;

use App\Entity\TypeEvenement;
use App\Form\TEvenementType;
use App\Form\TypeEvenementType;
use App\Repository\TypeEvenementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/typeevenement')]
class TypeEvenementController extends AbstractController
{
    #[Route('/', name: 'app_typeevent_index')]
    public function index(TypeEvenementRepository $typeEvenementRepository)
    {
        $typeEvenement= $typeEvenementRepository->findAll();
        return $this->render('type_evenement/index.html.twig', array(
            'typeevenement' => $typeEvenement
        ));
    }

    #[Route('/new', name: 'app_type_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry, TypeEvenementRepository $typeEvenementRepository)
    {
        $typeEvenement = new TypeEvenement();
        $form = $this->createForm(TEvenementType::class, $typeEvenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($typeEvenement);
            $em->flush();
            return $this->redirectToRoute('app_typeevent_index');
        }
        return $this->renderForm('type_evenement/add.html.twig',array(
            'typeEvenement' => $typeEvenement,
            'form' => $form
        ));
    }

    #[Route('/{id}', name: 'app_typeevenement_delete')]
    public function deletetypeevenement($id,TypeEvenementRepository $typeEvenementRepository,ManagerRegistry $managerRegistry)
    {
        $typeEvenement = $typeEvenementRepository->find($id);
        $typeEvenementRepository->remove($typeEvenement);
        $em = $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("app_typeevent_index");
    }

    #[Route('/updatetypeevenement/{id}', name: 'update_typeevenement')]
    public function updatetypeevenement($id,Request $request,TypeEvenementRepository $typeEvenementRepository,ManagerRegistry $managerRegistry)
    {
        $typeevenement = $typeEvenementRepository->find($id);
        $form = $this->createForm(TEvenementType::class, $typeevenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute('app_typeevent_index');
        }
        return $this->renderForm('type_evenement/update.html.twig',array(
            'typeevenement' => $typeevenement,
            'form' => $form
        ));
    }

    #[Route('/detailtype/{id}', name: 'app_typeevenement_detail')]
    public function detailtypeevenement($id,TypeEvenementRepository $Repository)
    {
        return $this->render('type_evenement/show.html.twig',array(
            'typeevenement' => $Repository->find($id)
        ));
    }

}