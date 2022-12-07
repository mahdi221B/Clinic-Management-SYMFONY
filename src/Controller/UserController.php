<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(UserRepository $repo): Response
    {

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user=$repo->findAll();
            return $this->render('User/Affiche.html.twig',
                ['c'=>$user]);
        }

        return $this->redirectToRoute('app_login');
        return $this->render('security/login.html.twig', ['error' => '',
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/admin/ajout', name: 'Aj')]
    function ajout(Request $request, UserPasswordHasherInterface $userPasswordHasher,ManagerRegistry $managerRegistry): Response{
        $User=new User();
        $form=$this->createForm(UserType::class,$User);
        $form->add('Ajout', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() &&$form->isValid() ){
            $em=$managerRegistry->getManager();

            $User->setMotPasse(
                $userPasswordHasher->hashPassword(
                    $User,
                   $form->get('MotPasse')->getData()
                )
            );

            $em->persist($User);
            $em->flush();
            return $this->redirectToRoute('affiche');
        }
        return $this->render("user/Ajout.html.twig",
            ['form'=>$form->createView()]);


    }
    #[Route('/admin/affiche', name: 'affiche')]
    function Affiche(UserRepository $repo){
        //request select * from Classroom
        // $rep=$this->getDoctrine()->getRepository(Classroom::class);
        $user=$repo->findAll();
        return $this->render('User/Affiche.html.twig',
            ['users'=>$user]);
    }
    #[Route('/admin/Update/{id_user}', name: 'Update')]
    function Update(Request $request,UserPasswordHasherInterface $userPasswordHasher,UserRepository $repository,ManagerRegistry $managerRegistry,$id_user)
    {
        $user = $repository->find($id_user);
        $form = $this->createForm(UserType::class, $user);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$managerRegistry->getManager();
            $user->setMotPasse(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('MotPasse')->getData()
                )
            );
            //$em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('affiche');

        }
        return $this->render("user/Ajout.html.twig",
            ['form' => $form->createView()]);
    }

    #[Route('/admin/activate/{id_user}', name: 'user_activate')]
    function Activate(Request $request,UserRepository $repository,ManagerRegistry $managerRegistry,$id_user)
    {
        $user = $repository->find($id_user);
        if(true === $user->isEnabled()) {
            $user->setEnabled(false);
        } else {
            $user->setEnabled(true);
        }
        $em=$managerRegistry->getManager();
        //$em->persist($classroom);
        $em->flush();
        return $this->redirectToRoute('affiche');
    }


    #[Route('/admin/delete/{id_user}', name: 'delete')]
    function remove($id_user,UserRepository $repository,ManagerRegistry $managerRegistry)
    {
        $classroom = $repository->find($id_user);
        $em=$managerRegistry->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute('affiche');
    }

    #[Route('/admin/detailuser/{id}', name: 'detail')]
    public function detailuser($id,UserRepository $repository)
    {
        $user = $repository->find($id);

        return $this->render("user/detail.html.twig",
            ['i' => $user]);
    }
    //////////////////////////////////      Roles Users                    ///////////////////////////////////////////////////////
    #[Route('doctor', name: 'doc')]
    public function doc()
                {
                    return $this->render('User/doc.html.twig');
                }
 //   infirmier
    #[Route('infirmier', name: 'infir')]
    public function infirmier()
    {
        return $this->render('User/infir.html.twig');
    }

    //route compte bloquée
    #[Route('blocked', name: 'blocked')]
    public function blocked()
    {
        return $this->render('User/blocked.html.twig');
    }

    //role user simple
    #[Route('user_role', name: 'user_role')]
    public function user_role()
    {
        return $this->render('User/userrole.html.twig');
    }

    //role agent de stock
    #[Route('agent_stock', name: 'agent_stock')]
    public function agent()
    {
        return $this->render('User/agent.html.twig');
    }

   // role  secretaire
    #[Route('secretaire', name: 'secretaire')]
    public function secretaire()
    {
        return $this->render('User/secretaire.html.twig');
    }

    // role technicien
    #[Route('technicien', name: 'technicien')]
    public function technicien()
    {
        return $this->render('User/technicien.html.twig');
    }
    /////////////////////////////////////////////////////////////////////////////////////
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->add('Insription', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setMotPasse(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('MotPasse')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_logout');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}