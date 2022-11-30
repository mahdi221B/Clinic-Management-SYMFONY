<?php

namespace App\Controller;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Form\CommandesArticlesType;
use App\Form\RetirerArticleType;
use App\Form\UpdatearticleType;
use App\Repository\ArticlesRepository;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(): Response
    {
        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
        ]);
    }
    #[Route('/new', name: 'article_new')]
    public function new(Request $request,ManagerRegistry $managerRegistry, ArticlesRepository $articlesRepository)
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('list_article');
        }
        return $this->renderForm('articles/add.html.twig',array(
            'articles' => $article,
            'form' => $form
        ));
    }
    #[Route('/listarticles', name: 'list_article')]
    public function listearticle(ArticlesRepository  $repository)
    {
        // $classrooms= $this->getDoctrine()->getRepository(ClassroomRepository::class)->findAll();
        $articles= $repository->findAll();
        return $this->render("articles/list.html.twig",array("articles"=>$articles));
    }

/*   #[Route('/{id}', name: 'article_delete')]
    public function deleteArticle ($id,ArticlesRepository $repository,ManagerRegistry $managerRegistry)
    {
        $articles = $repository->find($id);
        $repository->remove($articles);
        $em = $managerRegistry->getManager();
        $em->flush();
        return $this->redirectToRoute("list_article");
    }*/
    #[Route('/updateArticles/{id}', name: 'update_articles')]
    public function updateorie($id,Request $request,  ArticlesRepository $repository,ManagerRegistry $managerRegistry)
    {
        $Article = $repository->find($id);
        $form = $this->createForm( UpdatearticleType::class, $Article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->flush();
            return $this->redirectToRoute('list_article');
        }
        return $this->renderForm('Articles/update.html.twig',array(
            'article' => $Article,
            'form' => $form
        ));
    }


    #[Route('/allcommande/{id}', name: 'touslescommande')]
    public function touscommande($id, Request $request,ManagerRegistry $managerRegistry  ,CommandeRepository $CommandeRepository, ArticlesRepository $ArticlesRepository)
    {
        $Article = $ArticlesRepository->find($id);
        $commandes= $Article->getCommandelist() ;
        $totalespent=0;
        $expr = new Comparison('status', '=', 'validee');
        $criteria = new Criteria();
        $criteria->where($expr);
        $commandevalide = $commandes->matching($criteria);
        if(count($commandevalide) ==0  ){

            return $this->renderForm('commande/listnonvalide.html.twig');

        }else
                foreach ($commandevalide as $cle => $valeur) {
            $totale = $totalespent += $valeur->getPrixC();
        }

                return $this->renderForm('Articles/allvalidecomandes.html.twig',array(
                'article' => $Article,
                'commande'=>$commandevalide,
                'totale'=>$totale,
                //'form' => $form
            ));

    }

    #[Route('/retirerarticle/{id}', name: 'retirer')]
    public function retirer($id, Request $request,ManagerRegistry $managerRegistry  , ArticlesRepository $ArticlesRepository)
    {
        $Article = $ArticlesRepository->find($id);
        $form = $this->createForm(RetirerArticleType::class, null );
        $form ->handleRequest($request);
        if ($form->isSubmitted()   ) {
       $tab = $form->getData() ;
       $qte = (int)$tab["qtearetirer"] ;
       if ($qte < $Article->getQte()) {
           $Article->setQte($Article->getQte() - $qte);
           $em = $managerRegistry->getManager();
           $em->persist($Article);
           $em->flush();
           return $this->redirectToRoute("list_article");
       }
       else{
           return $this->renderForm('articles/error.html.twig');
       }
        }
        return $this->renderForm('articles/retier.html.twig',array(
            'Articles'=> $Article,
            'form'=>$form

        ));}

}


