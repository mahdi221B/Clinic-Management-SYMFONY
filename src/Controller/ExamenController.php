<?php

namespace App\Controller;

use App\Entity\Examen;
use App\Form\ExamenType;
use App\MailerService;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

use App\Repository\ExamenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;




use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ExamenController extends AbstractController
{
    #[Route('/examen', name: 'app_examen')]
    public function index(): Response
    {
        return $this->render('examen/index.html.twig', [
            'controller_name' => 'ExamenController',
        ]);
    }
    #[Route('/ajoutex', name: 'Ajex')]
    function ajoutex(
        Request $request,
        ManagerRegistry $managerRegistry,
        MailerService $mailerService

    ){
        $examen=new Examen();
        $new = true;


        $form=$this->createForm(ExamenType::class,$examen);
        $form->add('Add', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() &&$form->isValid() ){
            $em=$managerRegistry->getManager();
            $em->persist($examen);
            $em->flush();
            //:afficher d'un message
            if ($new){
                $message = " a été ajouté avec succès";
                $msgemail=$examen->getPatient().' '.$message;

            }
            $mailerService->sendEmail(content:$msgemail);
            return $this->redirectToRoute('listex');
        }
        return $this->render("examen/Ajoutex.html.twig",
            ['form'=>$form->createView()]);


    }

    #[Route('/listeex', name: 'listex')]

    public function list(ExamenRepository $rep){

        $examen=$rep->findAll();

        return $this->render('examen/listex.html.twig',
            ['c'=>$examen]);

    }
    #[Route('/deleteex/{id}', name: 'deleteex')]
    function remove($id,ExamenRepository$repository,ManagerRegistry $managerRegistry)
    {
        $examen = $repository->find($id);
        $em=$managerRegistry->getManager();
        $em->remove($examen);
        $em->flush();
        return $this->redirectToRoute('listex');
    }
    #[Route('/Updateex/{id}', name: 'Updateex')]
    function Update(Request $request,ExamenRepository $repository,ManagerRegistry $managerRegistry,$id)
    {
        $examen = $repository->find($id);
        $form = $this->createForm(ExamenType::class,$examen);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$managerRegistry->getManager();
            //$em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('listex');

        }
        return $this->render("examen/Ajoutex.html.twig",
            ['form' => $form->createView()]);
    }

    #[Route('/pieChart', name: 'pie_chart')]
    public function chart(Request $request, PaginatorInterface $paginator): Response
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $data = $this->getDoctrine()->getRepository(Examen::class)->findBy([], ['id' => 'desc']);

        $examens = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos examens)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );

        $pieChart = new PieChart();

        $examensData = $this->getDoctrine()->getRepository(Examen::class)->findAll();
        //$nExamensData = $this->getDoctrine()->getRepository(Examen::class)->findAll();

        // dd($categoriesData);

        $charts = array(['Examen', 'Number per Category']);
        // dd($charts);
        $nPos=0;
        $nNeg=0;
        foreach ($examensData as $eData) {
            if($eData->getResEx() == "+")
                $nPos++;
            if($eData->getResEx() == "-")
                $nNeg++;

        }

        array_push($charts, ["Pos", $nPos]);
        array_push($charts, ["-", $nNeg]);


        // dd($charts);

        $pieChart->getData()->setArrayToDataTable(
            $charts
        );

        // dd($pieChart);

        $pieChart->getOptions()->setTitle('Examen Number per Result');
        $pieChart->getOptions()->setHeight(400);
        $pieChart->getOptions()->setWidth(400);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#07600');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(25);

        return $this->render('examen/listex.html.twig', [
            'Examen' => $examens,
            'piechart' => $pieChart
        ]);
    }
    #[Route('/pieChart1', name: 'pie_chart')]
    public function statistiques(ExamenRepository $examenRepository, ExamenRepository $annRepo){
        // On va chercher toutes les catégories
        $examens = $examenRepository->findAll();

        $exNom = [];
        $exColor = [];
        $exCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($examens as $examen){
            $exNom[] = $examen->getId();
            $exColor[] = $examen->getColor();
            $exCount[] = count($examen->getResEx());
        }

        // On va chercher le nombre d'annonces publiées par date
        $resps = $examenRepository->countByresp();
        $resns = $examenRepository->countByresn();

        //$dates = [];
        $respCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($resps as $resp){
            $dates[] = $resp['Resp'];
            $respCount[] = $resp['count'];
        }

        return $this->render('examen/stats.html.twig', [
            'exNom' => json_encode($exNom),
            'exColor' => json_encode($exColor),
            'exCount' => json_encode($exCount),
            'resps' => json_encode($resps),
            'resns' => json_encode($resns),
        ]);
    }
    #[Route('/pie', name: 'app_homepage')]
    public function pie(ChartBuilderInterface $chartBuilder): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('examen/stats.html.twig', [
            'chart' => $chart,
        ]);
    }

    #[Route('/piee', name: 'piee')]

    public function listpie(){


        return $this->render('examen/piechart.html.twig',);

    }
}
