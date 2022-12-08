<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patient')]
    public function index(): Response
    {
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }

    #[Route('/addPatient', name: 'app_patient_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry, PatientRepository $patientRepository)
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($patient);
            $em->flush();
            return $this->redirectToRoute('patient_list');
        }
        return $this->renderForm('patient/add.html.twig',array(
            'patient' => $patient,
            'form' => $form
        ));
    }

    #[Route('/patientList', name: 'patient_list')]
    public function listpatient(PatientRepository $repository)
    {
        $patient= $repository->findAll();
        return $this->render("patient/show.html.twig",array("listpatient"=>$patient));
    }


    #[Route('/delete/{id}', name: 'app_patient_delete')]
    public function deletepatient ($id,PatientRepository $patientRepository,ManagerRegistry $managerRegistry)
    {
        $patient = $patientRepository->find($id);
        $em=$managerRegistry->getManager();
        $em->remove($patient);
        $em->flush();
        return $this->redirectToRoute("patient_list");
    }

    #[Route('/detailpatient/{id}', name: 'app_patient2_detail')]
    public function detailmedecin($id,PatientRepository $Repository)
    {
        return $this->render('patient/show.html.twig',array(
            'i' => $Repository->find($id)
        ));
    }

    #[Route('/updatepatient/{id}', name: 'update_patient')]
    public function updatemedecin($id,Request $request,  PatientRepository $repository,ManagerRegistry $managerRegistry)
    {
        $patient = $repository->find($id);
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute('patient_list');
        }
        return $this->renderForm('patient/update.html.twig',array(
            'patient' => $patient,
            'form' => $form
        ));
    }

    #[Route('/alls/age/{ageMin}/{ageMax}', name: 'personne.list.age')]
    public function patientByAge(ManagerRegistry $doctrine, $ageMin, $ageMax): Response {

        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findPersonnesByAgeInterval($ageMin, $ageMax);
        return $this->render('personne/index.html.twig', ['personnes' => $personnes]);
}}
