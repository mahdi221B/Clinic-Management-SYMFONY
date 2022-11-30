<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\ParticipationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{



    #[Route('/calendar1', name: 'app_calendar')]
    public function index1(EvenementRepository $evenementRepository)
    {
        $events = $evenementRepository->findAll();

        $rdvs = [];
        foreach($events as $event){
            $rdvs[] = [
                'title' => $event->getTitre()." / ",
                'resultat' => $event->getDescription(),
                'start' => $event->getDateDebut() ?? '',
                'end' =>($event->getDateFin()) ?? '',
            ];
        }
        $data = json_encode($rdvs);
        return $this->render('calender.html.twig', compact('data'));
    }
//($event->getDateDebut())?->format('Y-m-d') ?? '',




}