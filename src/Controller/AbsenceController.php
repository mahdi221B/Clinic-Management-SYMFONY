<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\User;
use App\Form\AbsenceType;
use App\Form\UserType;
use App\Repository\AbsenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;



class AbsenceController extends AbstractController
{
    #[Route('/admin/absence', name: 'app_absence')]
    public function index(): Response
    {
        return $this->render('absence/index.html.twig', [
            'controller_name' => 'AbsenceController',
        ]);
    }

    #[Route('/admin/absence/ajout', name: 'Ajab')]
    function ajoutab(Request $request,ManagerRegistry $managerRegistry){
        $Absence=new Absence();
        $form=$this->createForm(AbsenceType::class,$Absence);
        $form->add('Ajout', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() &&$form->isValid() ){
            $em=$managerRegistry->getManager();
            $em->persist($Absence);
            $em->flush();
            return $this->redirectToRoute('listab');
        }
        return $this->render("absence/Ajoutab.html.twig",
            ['form'=>$form->createView()]);


    }

    #[Route('/admin/absence/liste', name: 'listab')]

    public function list(AbsenceRepository $rep){

        $absence=$rep->findAll();

        return $this->render('absence/listab.html.twig',
            ['c'=>$absence]);

    }
    #[Route('/admin/absence/delete/{id}', name: 'deleteab')]
    function remove($id,AbsenceRepository $repository,ManagerRegistry $managerRegistry)
    {
        $absence = $repository->find($id);
        $em=$managerRegistry->getManager();
        $em->remove($absence);
        $em->flush();
        return $this->redirectToRoute('listab');
    }
    #[Route('/admin/absence/update/{id}', name: 'Updateab')]
    function Update(Request $request,AbsenceRepository $repository,ManagerRegistry $managerRegistry,$id)
    {
        $absence = $repository->find($id);
        $form = $this->createForm(AbsenceType::class,$absence);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$managerRegistry->getManager();
            //$em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('listab');

        }
        return $this->render("absence/Ajoutab.html.twig",
            ['form' => $form->createView()]);
    }


    #[Route('/admin/absence/detail/{id}', name: 'detailab')]
    public function detailabsence($id,AbsenceRepository $repository)
    {
        $user = $repository->find($id);
        return new Response(


            '<br>id: '.$user->getId()
            .' <br>nom: '.$user->getNom()
            .'<br>prenom: '.$user->getPrenom()
            .'<br>date_absence: '.$user->getDateAbsence()
            .'<br>dure_absence: '.$user->getDureAbsence()

            .'<br>justification: '.$user->getJustification()


        );
    }


}