<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Articles;

use App\Form\CommandeType;
use App\Form\DatecommandeType;
use App\Repository\ArticlesRepository;
use App\Repository\BudgetRepository;
use App\Repository\CommandeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
//use Twilio\Rest\Client;
class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    #[Route('/newcommande/{id}', name: 'new_commande')]
public function addcommande($id, Request $request,ManagerRegistry $managerRegistry ,CommandeRepository $CommandeRepository , ArticlesRepository $ArticlesRepository)
{
    $commande = new Commande();
    $form = $this->createForm(CommandeType::class, $commande);
    $form ->handleRequest($request);
    $Article = $ArticlesRepository->find($id);
    if ($form->isSubmitted()   ) {
        $em = $managerRegistry->getManager();
        $commande->setDateAjout(date("d-m-Y",strtotime("now")));
        $commande->setPrixC(($Article->getPrix()*$commande->getQteC()));
        $commande->setArticles($Article);
        $em -> persist($commande);
        $em->flush();
        return $this->redirectToRoute("list_commande");

    }
    return $this->renderForm('commande/addc.html.twig',array(
    'commande'=> $commande,
    'form'=>$form
)
    ) ;
}
    #[Route('/confirm/{id}', name: 'confirm_commande')]
    public function confirm($id ,Request $request,ManagerRegistry $managerRegistry ,CommandeRepository $CommandeRepository , ArticlesRepository $ArticlesRepository ,BudgetRepository $BudgetRepository)
    {
        $commande = $CommandeRepository->find($id);
        $budget =  $BudgetRepository->findOneBy(['id'=> '1' ]);
        $newFormat=date("d-m-Y",strtotime("now"));
        $commande->getArticles()->setQte($commande->getQteC()+$commande->getArticles()->getQte());
        $commande->setDateCloture($newFormat);
        $commande->setStatus("valideé");
        $commande->setDateCloture($newFormat);
        $commande->setMotifCloture("cloturé avec suceé");
        $budget->setMontant($budget->getMontant()-$commande->getPrixC() );
        $em = $managerRegistry->getManager();
        $em -> persist($commande);
        $em->flush();
        //$CommandeRepository->sendsms();
        return $this->redirectToRoute("list_commande");
    }


    #[Route('/refuse/{id}', name: 'refuse_commande')]
    public function refuse($id ,Request $request,ManagerRegistry $managerRegistry ,CommandeRepository $CommandeRepository , ArticlesRepository $ArticlesRepository)
    {

        $commande = $CommandeRepository->find($id);


        //  $Article = $ArticlesRepository->find($commande->getArticle());
        //  $Article->setQte($Article->getQte()+$commande->getQteC() );

        //$date = strtotime("now");
        $newFormat=date("d-m-Y",strtotime("now"));
        $commande->setDateCloture($newFormat);
        $commande->setStatus("refuse");
        $commande->setDateCloture($newFormat);
        $commande->setMotifCloture("cloturé avec echec");
        $em = $managerRegistry->getManager();
        $em -> persist($commande);
        $em->flush();
        return $this->redirectToRoute("list_commande");


    }

    #[Route('/listcommande', name: 'list_commande')]
    public function listeCommande(CommandeRepository  $repository ,BudgetRepository $BudgetRepository)
    {
        $Commande= $repository->findAll();
        $budget =$BudgetRepository->findAll();

        return $this->render("Commande/list.html.twig",array("commande"=>$Commande,
                "budget"=>$budget
                )
        );
    }

    #[Route('/commandesbetween', name: 'between')]
    public function between(Request $request,ManagerRegistry $managerRegistry  , ArticlesRepository $ArticlesRepository)
    {

        $form = $this->createForm(DatecommandeType::class, null );
        $form ->handleRequest($request);
        if ($form->isSubmitted()   ) {

//find all comandes
            // select commande whre  date-cloture is between tab[date1] and tab (date 2 and  where statut %like validé]
            $tab = $form->getData() ;
            $qte = (string)$tab["field_name"] ;
            var_dump($tab['date1']  ) ;
            var_dump($tab['date2']  ) ;
            $result = $tab['date1'] ->format('Y-m-d ');
            var_dump($result);



                return $this->redirectToRoute("list_article");

            }


        return $this->renderForm('commande/between.html.twig',array(

            'form'=>$form

        ));}

}
